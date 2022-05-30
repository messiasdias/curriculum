export const put = (key, value) => {
    let stringValue = ""
    if (typeof value != "string") stringValue = JSON.stringify(value)
    else stringValue = value
    window.localStorage.setItem(key, stringValue)
}

export const get = (key, defaultValue = null, convertJson = true) => {
    let value = localStorage.getItem(key)
    if(!!value && convertJson) {
        try {
            return JSON.parse(value)
        } catch (e) {
            return value
        }
    }
    return !!value ? value : defaultValue
}

export const remove = (key) => {
    window.localStorage.removeItem(key)
}

