import { readFileSync, statSync } from 'node:fs';
import { gzipSync } from 'node:zlib';

const buildRoot = new URL('../public/build/', import.meta.url);
const manifest = JSON.parse(readFileSync(new URL('manifest.json', buildRoot), 'utf8'));
const budgets = [
    ['Marketing CSS', 'resources/css/app.css', 25],
    ['Marketing JavaScript', 'resources/js/app.js', 10],
    ['Fida 2026 CSS', 'resources/css/modern.css', 14],
    ['Admin CSS', 'resources/css/admin.css', 18],
    ['Admin JavaScript', 'resources/js/admin.js', 8],
];
const failures = [];
const measuredFiles = new Set();

for (const [label, source, limitKiB] of budgets) {
    const output = manifest[source]?.file;

    if (!output) {
        failures.push(`${label}: Vite manifest entry [${source}] is missing.`);
        continue;
    }

    const fileUrl = new URL(output, buildRoot);
    const rawBytes = statSync(fileUrl).size;
    const gzipBytes = gzipSync(readFileSync(fileUrl)).byteLength;
    const gzipKiB = gzipBytes / 1024;
    measuredFiles.add(output);

    process.stdout.write(
        `${label}: ${(rawBytes / 1024).toFixed(2)} KiB raw, ${gzipKiB.toFixed(2)} KiB gzip / ${limitKiB.toFixed(2)} KiB budget\n`,
    );

    if (gzipKiB > limitKiB) {
        failures.push(`${label}: ${gzipKiB.toFixed(2)} KiB gzip exceeds the ${limitKiB.toFixed(2)} KiB budget.`);
    }
}

const totalGzipKiB = [...measuredFiles]
    .map((file) => gzipSync(readFileSync(new URL(file, buildRoot))).byteLength)
    .reduce((total, bytes) => total + bytes, 0) / 1024;
const totalBudgetKiB = 70;

process.stdout.write(`Measured application assets: ${totalGzipKiB.toFixed(2)} KiB gzip / ${totalBudgetKiB.toFixed(2)} KiB total budget\n`);

if (totalGzipKiB > totalBudgetKiB) {
    failures.push(`Measured application assets exceed the ${totalBudgetKiB.toFixed(2)} KiB total gzip budget.`);
}

if (failures.length > 0) {
    for (const failure of failures) {
        process.stderr.write(`Asset budget failure: ${failure}\n`);
    }

    process.exit(1);
}

process.stdout.write('Asset budget passed.\n');
