<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" :inline-label-vertical-alignment="\Filament\Support\Enums\VerticalAlignment::Center">
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}').defer }">
        <!-- Interact with the `state` property in Alpine.js -->
        <x-filament::input.wrapper :disabled="$isDisabled()" :inline-prefix="$isPrefixInline()" :inline-suffix="$isSuffixInline()" :prefix="$getPrefixLabel()"
            :prefix-actions="$getPrefixActions()" :prefix-icon="$getPrefixIcon()" :prefix-icon-color="$getPrefixIconColor()" :suffix="$getSuffixLabel()" :suffix-actions="$getSuffixActions()"
            :suffix-icon="$getSuffixIcon()" :suffix-icon-color="$getSuffixIconColor()" :valid="!$errors->has($getStatePath())" x-data="{}" :attributes="\Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())->class([
                'fi-fo-text-input overflow-hidden',
            ])">

            <x-filament::input :attributes="\Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                ->merge($getExtraAlpineAttributes(), escape: false)
                ->merge(
                    [
                        'autofocus' => $isAutofocused(),
                        'disabled' => $isDisabled(),
                        'id' => $getId(),
                        'inlinePrefix' =>
                            $isPrefixInline() &&
                            (count($getPrefixActions()) || $getPrefixIcon() || filled($getPrefixLabel())),
                        'inlineSuffix' =>
                            $isSuffixInline() &&
                            (count($getSuffixActions()) || $getSuffixIcon() || filled($getSuffixLabel())),
                        'maxlength' => !$isConcealed ? $getMaxLength() : null,
                        'minlength' => !$isConcealed ? $getMinLength() : null,
                        'required' => $isRequired() && !$isConcealed,
                        'type' => 'text',
                        $applyStateBindingModifiers('wire:model') => $getStatePath(),
                    ],
                    escape: false,
                )
                ->merge([])
                ->class(['fi-fo-text-input overflow-hidden'])" />
        </x-filament::input.wrapper>
    </div>

        <div class="pt-10">
            @switch(config('filament-captcha.engine', 'mews'))
                @case('mews')
                @default
                    {!! Captcha::img() !!}
                    @break
            @endswitch
        </div>
</x-dynamic-component>
