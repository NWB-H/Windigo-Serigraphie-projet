import { inject, type InjectionKey } from 'vue'

export function injectStrict<T>(key: InjectionKey<T>): T {
    const resolved = inject(key)

    if (!resolved) {
        throw new Error(`Injection "${String(key)}" not found.`)
    }

    return resolved
}
