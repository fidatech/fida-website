<?php

namespace App\Support;

/**
 * Line icons for the Fida 2026 mega-menu (24px grid, stroke drawn with currentColor).
 */
final class ModernIcons
{
    private const PATHS = [
        'layers' => '<path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="m3 13 9 5 9-5"/><path d="m3 17.5 9 4.5 9-4.5" opacity=".55"/>',
        'calculator' => '<rect x="5" y="3" width="14" height="18" rx="2.5"/><path d="M8.5 7h7"/><path d="M8.5 11.5h.01M12 11.5h.01M15.5 11.5h.01M8.5 15h.01M12 15h.01M15.5 15v2.5M8.5 18h.01M12 18h.01"/>',
        'users' => '<circle cx="9" cy="8" r="3.2"/><path d="M3.5 19.5c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/><path d="M15.5 5.2a3 3 0 0 1 0 5.6M17.5 14.8c1.6.6 2.7 2.2 3 4.7"/>',
        'code' => '<path d="m8.5 8-4 4 4 4M15.5 8l4 4-4 4M13.5 5l-3 14"/>',
        'phone' => '<rect x="6.5" y="2.5" width="11" height="19" rx="2.5"/><path d="M10.5 18.5h3"/>',
        'receipt' => '<path d="M6 3h12v18l-2.2-1.5L13.6 21l-1.6-1.5-1.6 1.5-2.2-1.5L6 21V3Z"/><path d="M9 8h6M9 11.5h6M9 15h3.5"/>',
        'sparkles' => '<path d="M11 3.5 12.7 8.3 17.5 10l-4.8 1.7L11 16.5l-1.7-4.8L4.5 10l4.8-1.7L11 3.5Z"/><path d="M18 15v4M16 17h4"/>',
        'file' => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z"/><path d="M14 3v5h5M9 13h6M9 17h4"/>',
        'chart' => '<path d="M4 20V4M4 20h16"/><path d="m7.5 15 3.5-4 3 2.5 5-6.5"/>',
        'chat' => '<path d="M5 5h14a1.5 1.5 0 0 1 1.5 1.5v9A1.5 1.5 0 0 1 19 17h-8l-4.5 3.5V17H5a1.5 1.5 0 0 1-1.5-1.5v-9A1.5 1.5 0 0 1 5 5Z"/><path d="M8 10h8M8 13h5"/>',
        'box' => '<path d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z"/><path d="m4 7.5 8 4.5 8-4.5M12 12v9"/>',
        'kanban' => '<rect x="3.5" y="4" width="17" height="16" rx="2.5"/><path d="M9 4v16M15 4v16M5.8 8h1M11.3 8h1.4M11.3 11.5h1.4M17 8h1"/>',
        'cap' => '<path d="m12 4 10 5-10 5L2 9l10-5Z"/><path d="M6 11v5c1.8 1.6 3.8 2.4 6 2.4s4.2-.8 6-2.4v-5M22 9v5"/>',
        'flask' => '<path d="M9.5 3h5M10 3v6l-5 9a2 2 0 0 0 1.8 3h10.4A2 2 0 0 0 19 18l-5-9V3"/><path d="M7.5 15h9"/>',
        'globe' => '<circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17M12 3.5c2.3 2.4 3.4 5.2 3.4 8.5s-1.1 6.1-3.4 8.5c-2.3-2.4-3.4-5.2-3.4-8.5S9.7 5.9 12 3.5Z"/>',
        'building' => '<path d="M5 21V5a1.5 1.5 0 0 1 1.5-1.5h7A1.5 1.5 0 0 1 15 5v16M15 9h3.5A1.5 1.5 0 0 1 20 10.5V21M3 21h18"/><path d="M8.5 7.5h3M8.5 11h3M8.5 14.5h3"/>',
        'server' => '<rect x="4" y="3.5" width="16" height="7" rx="1.8"/><rect x="4" y="13.5" width="16" height="7" rx="1.8"/><path d="M7.5 7h.01M7.5 17h.01M11 7h5.5M11 17h5.5"/>',
        'network' => '<rect x="9.5" y="3" width="5" height="5" rx="1"/><rect x="3" y="16" width="5" height="5" rx="1"/><rect x="16" y="16" width="5" height="5" rx="1"/><path d="M12 8v4M5.5 16v-2.2a1.8 1.8 0 0 1 1.8-1.8h9.4a1.8 1.8 0 0 1 1.8 1.8V16"/>',
        'cloud' => '<path d="M7 18.5a4.5 4.5 0 0 1-.5-9A6 6 0 0 1 18 9a4.8 4.8 0 0 1-.5 9.5H7Z"/>',
        'shield' => '<path d="M12 3 19.5 6v5.5c0 4.5-3.1 8.3-7.5 9.5-4.4-1.2-7.5-5-7.5-9.5V6L12 3Z"/><path d="m9 12 2.2 2.2L15.5 10"/>',
        'cpu' => '<rect x="6" y="6" width="12" height="12" rx="2"/><rect x="9.5" y="9.5" width="5" height="5" rx=".8"/><path d="M9.5 2.5V6M14.5 2.5V6M9.5 18v3.5M14.5 18v3.5M2.5 9.5H6M2.5 14.5H6M18 9.5h3.5M18 14.5h3.5"/>',
        'plug' => '<path d="M9 3v4.5M15 3v4.5M6.5 7.5h11V11a5.5 5.5 0 0 1-11 0V7.5Z"/><path d="M12 16.5V21"/>',
        'headset' => '<path d="M4.5 14v-2a7.5 7.5 0 0 1 15 0v2"/><rect x="3.5" y="13" width="4" height="6" rx="1.5"/><rect x="16.5" y="13" width="4" height="6" rx="1.5"/><path d="M18.5 19c0 1.4-1.6 2-4 2h-1.5"/>',
        'radio' => '<circle cx="12" cy="12" r="2"/><path d="M8.2 15.8a5.4 5.4 0 0 1 0-7.6M15.8 8.2a5.4 5.4 0 0 1 0 7.6M5.3 18.7a9.5 9.5 0 0 1 0-13.4M18.7 5.3a9.5 9.5 0 0 1 0 13.4"/>',
        'landmark' => '<path d="m3 9 9-5.5L21 9H3ZM4.5 20.5h15M3 20.5h18"/><path d="M6 9v9M10 9v9M14 9v9M18 9v9"/>',
        'heart' => '<path d="M12 20s-7.5-4.6-7.5-10.2A4.3 4.3 0 0 1 12 7a4.3 4.3 0 0 1 7.5 2.8C19.5 15.4 12 20 12 20Z"/>',
        'helmet' => '<path d="M5 16.5v-1.8a7 7 0 0 1 14 0v1.8"/><path d="M10 8.2V5.5h4v2.7M2.5 16.5h19v2.5h-19z"/>',
        'factory' => '<path d="M3 21V10l5 3.2V10l5 3.2V6.5h3l1 3.5h3.5L21 21H3Z"/><path d="M7 17h2M11.5 17h2M16 17h2"/>',
        'medical' => '<rect x="3.5" y="3.5" width="17" height="17" rx="4"/><path d="M12 8v8M8 12h8"/>',
        'coins' => '<ellipse cx="9" cy="7" rx="5.5" ry="2.5"/><path d="M3.5 7v4.5c0 1.4 2.5 2.5 5.5 2.5M3.5 11.5V16c0 1.4 2.5 2.5 5.5 2.5"/><ellipse cx="15" cy="13.5" rx="5.5" ry="2.5"/><path d="M9.5 13.5V18c0 1.4 2.5 2.5 5.5 2.5s5.5-1.1 5.5-2.5v-4.5"/>',
        'truck' => '<path d="M2.5 6.5h11v10h-11zM13.5 10h4l3.5 3.5v3h-7.5"/><circle cx="6.5" cy="17.5" r="2"/><circle cx="17" cy="17.5" r="2"/>',
        'exchange' => '<path d="M4 8h14l-3.5-3.5M20 16H6l3.5 3.5"/>',
        'pill' => '<rect x="2.6" y="8.3" width="18.8" height="7.4" rx="3.7" transform="rotate(-45 12 12)"/><path d="m8.7 8.7 6.6 6.6"/>',
        'cart' => '<path d="M3 4h2.2l2.3 11h10.2l2.3-7.5H6.4"/><circle cx="9" cy="19.5" r="1.4"/><circle cx="17" cy="19.5" r="1.4"/>',
        'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="2.2"/><path d="M8.5 7V5.2A1.7 1.7 0 0 1 10.2 3.5h3.6a1.7 1.7 0 0 1 1.7 1.7V7M3 12.5h18"/>',
        'mountain' => '<path d="m2.5 20 7-12 4 6.5 2.5-3.5 5.5 9h-19Z"/><path d="m7.5 11.5 2 1.5 1.8-1.5"/>',
        'bolt' => '<path d="M13 2.5 4.5 13.5h6.5L10 21.5l8.5-11H12l1-8Z"/>',
        'sprout' => '<path d="M12 21v-9"/><path d="M12 12c0-4 2.6-6.5 7.5-6.5 0 4.6-2.8 6.5-7.5 6.5ZM12 14.5c0-3.3-2.2-5.5-6.5-5.5 0 4 2.3 5.5 6.5 5.5Z"/>',
        'ship' => '<path d="M3 15.5h18l-2.5 4.5h-13L3 15.5ZM6 15.5V10h12v5.5M9.5 10V6.5h5V10"/>',
        'antenna' => '<path d="M12 10.5v10.5M8.5 21h7"/><circle cx="12" cy="8.5" r="2"/><path d="M8 4.5a5.6 5.6 0 0 0 0 8M16 4.5a5.6 5.6 0 0 1 0 8"/>',
        'terminal' => '<rect x="3" y="4" width="18" height="16" rx="2.5"/><path d="m7 9 3 3-3 3M12.5 15H17"/>',
        'growth' => '<path d="M4 19.5h16"/><path d="m5 15 4.5-4.5 3.5 3L19 7.5"/><path d="M14.5 7.5H19V12"/>',
        'wrench' => '<path d="M15 4.5a4.5 4.5 0 0 0-4.3 5.8L4.2 16.8a2.1 2.1 0 0 0 3 3l6.5-6.5A4.5 4.5 0 0 0 19.5 9l-2.8 2.8-2.4-.4-.4-2.4L16.7 6.2A4.5 4.5 0 0 0 15 4.5Z"/>',
        'info' => '<circle cx="12" cy="12" r="8.5"/><path d="M12 11v5.5M12 7.8h.01"/>',
        'folder' => '<path d="M3.5 7A1.5 1.5 0 0 1 5 5.5h4.3l2 2.2H19A1.5 1.5 0 0 1 20.5 9.2v8.3A1.5 1.5 0 0 1 19 19H5a1.5 1.5 0 0 1-1.5-1.5V7Z"/>',
        'tag' => '<path d="M3.5 12.4V4.5a1 1 0 0 1 1-1h7.9l8.1 8.1a1.5 1.5 0 0 1 0 2.1l-6.8 6.8a1.5 1.5 0 0 1-2.1 0l-8.1-8.1Z"/><circle cx="8" cy="8" r="1.4"/>',
        'news' => '<path d="M5 4.5h12a1.5 1.5 0 0 1 1.5 1.5v12.5a1.5 1.5 0 0 0 3 0V9h-3"/><path d="M5 4.5A1.5 1.5 0 0 0 3.5 6v12.5A1.5 1.5 0 0 0 5 20h15M7 8.5h7.5M7 12h7.5M7 15.5h4.5"/>',
        'help' => '<circle cx="12" cy="12" r="8.5"/><path d="M9.6 9.4a2.5 2.5 0 0 1 4.8.9c0 1.7-2.4 2.2-2.4 3.7M12 16.8h.01"/>',
        'clipboard' => '<rect x="5" y="4.5" width="14" height="16.5" rx="2"/><path d="M9 4.5V3.5h6v1M8.5 10.5h7M8.5 14h7M8.5 17.5h4"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2.2"/><path d="m3.8 6.5 8.2 6.5 8.2-6.5"/>',
        'arrow' => '<path d="M5 12h14M13.5 6.5 19 12l-5.5 5.5"/>',
        'grid' => '<rect x="4" y="4" width="6.5" height="6.5" rx="1.5"/><rect x="13.5" y="4" width="6.5" height="6.5" rx="1.5"/><rect x="4" y="13.5" width="6.5" height="6.5" rx="1.5"/><rect x="13.5" y="13.5" width="6.5" height="6.5" rx="1.5"/>',
    ];

    /**
     * Keywords matched against a page slug, first match wins.
     */
    private const SLUG_ICONS = [
        'erpnext' => 'layers', 'erp-implementation' => 'layers', 'erp-systems' => 'layers', 'enterprise-software' => 'layers',
        'accounting' => 'calculator', 'financial-management' => 'coins', 'hrmis' => 'users', 'custom-software' => 'code',
        'mobile-app' => 'phone', 'pos-software' => 'receipt', 'ai-automation' => 'sparkles', 'document-management' => 'file',
        'business-intelligence' => 'chart', 'crm' => 'chat', 'procurement' => 'box', 'project-management' => 'kanban',
        'school' => 'cap', 'university' => 'cap', 'laboratory' => 'flask', 'web-digital' => 'globe', 'laravel-website' => 'globe',
        'technology-company' => 'building', 'government-ngo' => 'landmark', 'grant-management' => 'coins',
        'monitoring-evaluation' => 'chart', 'beneficiary' => 'heart', 'asset-maintenance' => 'wrench',
        'data-center' => 'server', 'network-infrastructure' => 'network', 'cloud-server' => 'cloud', 'cybersecurity' => 'shield',
        'hardware' => 'cpu', 'systems-integration' => 'plug', 'managed-it' => 'headset', 'iot' => 'radio',
        'mis-development' => 'chart', 'digital-transformation' => 'growth', 'consulting' => 'chat', 'tender' => 'clipboard',
        'security-hosting' => 'shield', 'database' => 'server', 'process-analysis' => 'kanban', 'integration-api' => 'plug',
        'training-support' => 'headset',
        'government-public' => 'landmark', 'ngo-ingo' => 'heart', 'real-estate-construction' => 'building',
        'construction' => 'helmet', 'real-estate' => 'building', 'manufacturing' => 'factory', 'hospital' => 'medical',
        'transport' => 'truck', 'sarafi' => 'exchange', 'pharmacy' => 'pill', 'wholesale' => 'cart',
        'professional-services' => 'briefcase', 'mining' => 'mountain', 'energy' => 'bolt', 'agriculture' => 'sprout',
        'import-export' => 'ship', 'telecommunications' => 'antenna',
    ];

    public static function svg(string $name, int $size = 20): string
    {
        $paths = self::PATHS[$name] ?? self::PATHS['grid'];

        return '<svg class="mx-ico" viewBox="0 0 24 24" width="'.$size.'" height="'.$size.'" aria-hidden="true" focusable="false">'.$paths.'</svg>';
    }

    public static function forSlug(string $slug): string
    {
        foreach (self::SLUG_ICONS as $keyword => $icon) {
            if (str_contains($slug, $keyword)) {
                return $icon;
            }
        }

        return 'grid';
    }

    public static function has(string $name): bool
    {
        return isset(self::PATHS[$name]);
    }
}
