const params = new URLSearchParams(window.location.search);
const queryObject = Object.fromEntries(params.entries());

export default {
    queryObject,
    ...queryObject,
    search: window.location?.search,
    tags: (queryObject?.tags?.split(",") || queryObject?.tags || [])?.filter(v=>v)
}