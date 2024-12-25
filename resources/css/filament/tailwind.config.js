import preset from '../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/archilex/filament-filter-sets/**/*.php',
        './vendor/awcodes/filament-quick-create/resources/**/*.blade.php',
        './vendor/awcodes/filament-table-repeater/resources/**/*.blade.php',
        './vendor/awcodes/palette/resources/views/**/*.blade.php',
        './vendor/jaocero/radio-deck/resources/views/**/*.blade.php',
    ],
}
