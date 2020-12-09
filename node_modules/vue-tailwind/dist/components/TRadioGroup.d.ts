import { CreateElement, VNode } from 'vue';
import NormalizedOption from '../types/NormalizedOption';
import NormalizedOptions from '../types/NormalizedOptions';
declare const TRadioGroup: import("vue/types/vue").ExtendedVue<{
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
    localValue: string | number;
}, {
    createRadioGroup(createElement: CreateElement): VNode;
    createRadioOptions(createElement: CreateElement): VNode[];
    createRadioOption(createElement: CreateElement, option: NormalizedOption, index: number): VNode;
    buildId(option: NormalizedOption, index: number): string;
    inputHandler(value: string | number): void;
    blurHandler(e: FocusEvent): void;
    focusHandler(e: FocusEvent): void;
}, unknown, {
    groupWrapperTag: string;
    wrapperTag: string;
    inputWrapperTag: string;
    labelTag: string;
    fixedClasses: any;
    classes: any;
}>;
export default TRadioGroup;
