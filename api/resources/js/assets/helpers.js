import moment from "moment"
moment.locale('pt-Br'); 

export function dateTimeToLocaleString(datetime, altValue = null){
    return new Date(datetime).toLocaleString() || altValue
}

export function dateTimeToLocaleMoment(datetime, altValue = null){
    return moment(datetime).format('ll')  || altValue
}

export function dateTimeCompare(date = null, date2 = null){
    let datetime =  new Date(date).getTime()
    let datetime2 = new Date(date2).getTime()

    if (datetime > datetime2) return 1
    if (datetime < datetime2) return 2
    if (datetime === datetime2) return 3
    return 0
}
export function dateTimeCompareToString(date = null, date2 = null){
    if (dateTimeCompare(date, date2) === 1) return 'date1'
    if (dateTimeCompare(date, date2) === 2) return 'date2'
    if (dateTimeCompare(date, date2) === 3) return 'equals'
    return 'invalid'
}

export const nowString = new Date().toISOString()
export const nowTimestemp = Date.now()