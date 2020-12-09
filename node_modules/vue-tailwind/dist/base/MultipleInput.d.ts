declare const MultipleInput: import("vue/types/vue").ExtendedVue<{
    localValue: string | number;
} & {
    guessOptionValue(option: import("../types/InputOption").default): any;
    guessOptionText(option: import("../types/InputOption").default): any;
    normalizeOptions(options: import("../types/InputOptions").default): import("../types/NormalizedOptions").default;
    normalizeOption(option: import("../types/InputOption").default): import("../types/NormalizedOption").default;
} & {
    normalizedOptions: import("../types/NormalizedOptions").default;
    flattenedOptions: import("../types/NormalizedOptions").default;
} & {
    value: string | number;
    valueAttribute: string;
    textAttribute: string;
    options: any;
} & {
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
} & import("vue").default, unknown, unknown, unknown, {
    value: string | number | unknown[];
    multiple: boolean;
}>;
export default MultipleInput;
