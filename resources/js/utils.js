export const getUrlQuery = function(param = null) {
  let url = new URL(window.location.href)
  if (param) {
    return url.searchParams.get(param)
  }

  let params = {}
  url.searchParams.forEach((v, k) => (params[k] = v))
  return params
}
