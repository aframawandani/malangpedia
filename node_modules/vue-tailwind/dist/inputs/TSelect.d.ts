import { CreateElement, VNode } from 'vue';
import NormalizedOption from '../types/NormalizedOption';
import NormalizedOptions from '../types/NormalizedOptions';
declare const TSelect: import("vue/types/vue").ExtendedVue<{
    value: string | number | unknown[];
    multiple: boolean;
} & {
    localValue: string | number;
} & {
    guessOptionValue(option: import("../types/InputOption").default): any;
    guessOptionText(option: import("../types/InputOption").default): any;
    normalizeOptions(options: import("../types/InputOptions").default): NormalizedOptions;
    normalizeOption(option: import("../types/InputOption").default): NormalizedOption;
} & {
    normalizedOptions: NormalizedOptions;
    flattenedOptions: NormalizedOptions;
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
} & import("vue").default, {
    localValue: string | number | (unknown[] & string) | (unknown[] & number);
}, {
    createSelectWrapper(createElement: CreateElement): VNode;
    createArrow(createElement: CreateElement): VNode;
    createSelect(createElement: CreateElement): VNode;
    createOptions(createElement: CreateElement, value: string | number | unknown[]): VNode[];
    createOptgroup(createElement: CreateElement, option: NormalizedOption, value: string | number | unknown[]): VNode;
    createOption(createElement: CreateElement, option: NormalizedOption, value: string | number | unknown[]): VNode;
    changeHandler(e: Event): void;
    blurHandler(e: FocusEvent): void;
    focusHandler(e: FocusEvent): void;
    blur(): void;
    focus(options?: FocusOptions | undefined): void;
}, {
    normalizedOptionsWithPlaceholder: NormalizedOptions;
}, {
    placeholder: string;
    wrapped: boolean;
    classes: any;
}>;
export default TSelect;
