type Kel<T> = {
    on: (
        event: '__EVENT_STORE_UPDATED' | '__EVENT_HYDRATE_STORE' | string,
        cb: (store: T) => void
    ) => void,
    emit: (event: string, payload?: Partial<T> | ((store: T) => T)) => void,
    getStore: () => T;
}

export type KelConstructor<T> = {
    new(store: T): Kel<T>;
};