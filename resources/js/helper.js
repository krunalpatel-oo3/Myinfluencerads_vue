const myPlugin = {
    install(app) {
        app.config.globalProperties.$numFormat = (key) => {
            return Number(key).toLocaleString();
        },
        app.config.globalProperties.$numFormatWithDollar = (key) => {
            return key ? '$' + Number(key).toLocaleString() : '-';
        },
        app.config.globalProperties.$subString = (text, len=10) => {
            return text.substring(0, len)+'...';
        }
    }
}
 
export default myPlugin;