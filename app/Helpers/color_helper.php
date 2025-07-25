<?php

if (!function_exists('getColorForStatus')) {
    function getColorForStatus($status) {
        switch ($status) {
            case 'pending': return '#facc15'; // kuning
            case 'confirmed': return '#3b82f6'; // biru
            case 'completed': return '#10b981'; // hijau
            case 'cancelled': return '#ef4444'; // merah
            default: return '#6b7280'; // abu
        }
    }
}
