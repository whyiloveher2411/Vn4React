import { getCookie, setCookie } from "./cookie";
import { toCamelCase } from "./helper";
import { plugins } from "./plugin";

let languageDefault = {
    "flag": "US",
    "code": "en_US",
    "note": "United States",
    "label": "English"
};

export function init() {

    let language = getLanguage();
    window.language = language;

    try {
        window.__i18 = require('./i18n/' + language.code);

        window.__i18.__p = {};

    } catch (error) {
        window.__i18 = { __p: {} };
    }
}

export function changeLanguage(data) {
    setCookie('language', JSON.stringify(data));
    delete window.language;
    init();
}

export function getLanguage() {

    if (window.language) return window.language;

    let languages = getLanguages();

    let language = JSON.parse(getCookie("language"));

    let languageBowser = false;

    if (language) {
        let isCheck = false;
        for (let i = 0; i < languages.length; i++) {
            if (language.code === languages[i].code) {
                isCheck = true;
            }

            if (navigator.language === languages[i].shortCode) {
                languageBowser = languages[i];
            }
        }
        if (isCheck) {
            return language;
        }
    } else {
        for (let i = 0; i < languages.length; i++) {
            if (navigator.language === languages[i].shortCode) {
                languageBowser = languages[i];
                break;
            }
        }
    }

    if (languageBowser !== false) {
        setCookie('language', JSON.stringify(languageBowser), 365);
        return languageBowser;
    }

    setCookie('language', JSON.stringify(languageDefault), 365);
    return languageDefault;
}

export function __(transText, param = false) {

    let result = transText;

    if (window.__i18[transText]) {
        result = window.__i18[transText];
    }

    if (param) {

        let find = Object.keys(param);
        let replace = Object.values(param);

        for (var i = 0; i < find.length; i++) {
            result = result.replace('{{' + find[i] + '}}', replace[i]);
        }
    }

    return result;
}

export function __i18n(transText, param = false) {
    return __(transText, param);
}


export function __p(transText, pluginKey, param = false) {

    let result = transText;

    if (!window.__i18.__p[pluginKey]) {

        let language = getLanguage();

        let pluginList = plugins();

        if (pluginList[pluginKey]) {
            try {
                window.__i18.__p[pluginKey] = require('./../plugins/' + toCamelCase(pluginKey) + '/i18n/' + language.code);
            } catch (error) {
                window.__i18.__p[pluginKey] = {};
            }
        }
    }

    if (window.__i18.__p[pluginKey][transText]) {
        result = window.__i18.__p[pluginKey][transText];
    }

    if (param) {

        let find = Object.keys(param);
        let replace = Object.values(param);

        for (var i = 0; i < find.length; i++) {
            result = result.replace('{{' + find[i] + '}}', replace[i]);
        }
    }

    return result;
}

export function getLanguages() {
    return require('./../languages.json');
}


init();