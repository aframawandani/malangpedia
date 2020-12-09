import InputOption from '../types/InputOption';
import InputOptions from '../types/InputOptions';
import NormalizedOption from '../types/NormalizedOption';
import NormalizedOptions from '../types/NormalizedOptions';
declare const InputWithOptions: import("vue/types/vue").ExtendedVue<{
    id: string;
    name: string;
    disabled: boolean;
    readonly: boolean;
    autofocus: boolean;
    required: boolean;
    tabindex: string | number;
} & {
    getElementCssClass(elementName?: string | undefined, defaultClasses?: import("../types/CssClass").default): import("../types/CssClass").default;
} & {
    componentClass: import("../types/CssClass").default;
    activeVariant: string | undefined;
} & {
    classes: any;
    fixedClasses: any;
    variants: any;
    variant: any;
} & import("vue").default, {
    localValue: string | number;
}, {
    guessOptionValue(option: InputOption): any;
    guessOptionText(option: InputOption): any;
    normalizeOptions(options: InputOptions): NormalizedOptions;
    normalizeOption(option: InputOption): NormalizedOption;
}, {
    normalizedOptions: NormalizedOptions;
    flattenedOptions: NormalizedOptions;
}, {
    value: string | number;
    valueAttribute: string;
    textAttribute: string;
    options: any;
}>;
export default InputWithOptions;
