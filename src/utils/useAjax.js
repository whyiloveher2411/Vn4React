import { updateRequireLogin } from 'actions/requiredLogin';
import { Loading } from 'components';
import { useSnackbar } from 'notistack';
import React from 'react';
import { useDispatch } from 'react-redux';
import { getLanguage } from './i18n';

const urlPrefixDefault = process.env.REACT_APP_BASE_URL + 'api/admin/';

const language = getLanguage();

export function useAjax(props) {

    const dispatch = useDispatch();

    const [open, setOpen] = React.useState(false);

    const { enqueueSnackbar } = useSnackbar();

    const showNotification = (content, type = 'error', option = null) => {

        let optionDefault = { variant: type, anchorOrigin: { vertical: 'bottom', horizontal: 'left' }, ...option };

        if (typeof content === 'string') {
            enqueueSnackbar({ content: content, options: optionDefault }, optionDefault);
            return;
        }

        if (content.content) {
            enqueueSnackbar(content, content.options);
        }
    }

    const callbackSuccess = async (params, response) => {

        let { success } = params;

        if (!response.ok) {

            if (params.error) {
                params.error(response, enqueueSnackbar);
                return;
            }

            let result = await response.json();

            if (result.message) {
                showNotification(result.message);
                return;
            } else {
                throw Error(response.statusText);
            }
        }

        let result = await response.json();

        if (result.message) {
            showNotification(result.message);
        }

        if (result.require_login) {
            requestLogin(params.url, {
                callback: bind,
                params: params
            });
        }

        if (success) {
            success(result, showNotification);
        }

    }

    const requestLogin = (url, param) => {
        if (!window.__afterLogin) window.__afterLogin = {};
        window.__afterLogin[url] = param;
        dispatch(updateRequireLogin({ open: true, updateUser: false }));
    }

    const callbackError = (error) => {
        showNotification(error.toString());
    }

    const callbackFinally = (params) => {
        if (params.finally) {
            params.finally(enqueueSnackbar);
        };
        setOpen(false);
    }

    const bind = (params) => {

        let { url, urlPrefix = null, method, data = {}, loading = true } = params;

        let headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Origin': '',
            'Host': 'localhost:3000'
        };

        if (localStorage.getItem('access_token')) {
            headers.Authorization = 'Bearer ' + localStorage.getItem('access_token');
        }

        if (loading) {
            setOpen(true);
        }

        if (!data) data = {};

        data.__l = window.btoa(language.code + '#' + Date.now());
        // if (data) {
        method = 'POST';
        // }

        fetch((urlPrefix ?? urlPrefixDefault) + url, {
            headers: headers,
            method: method,
            body: JSON.stringify(data)
        }).then(async (response) => {

            callbackSuccess(params, response);

            // if (!response.ok) {

            //     if (params.error) {
            //         params.error(response, enqueueSnackbar);
            //         return;
            //     }

            //     let result = await response.json();

            //     if (result.message) {
            //         // if (result.message.content) {
            //         //     showNotification(result.message.content, null, result.message.options);
            //         // } else {
            //         showNotification(result.message);
            //         // }
            //         return;
            //     } else {
            //         throw Error(response.statusText);
            //     }
            // }

            // let result = await response.json();

            // if (result.message) {
            //     showNotification(result.message);
            // }

            // if (result.require_login) {

            //     if (!window.__afterLogin) window.__afterLogin = {};

            //     window.__afterLogin[params.url] = {
            //         callback: bind,
            //         params: params
            //     };

            //     dispatch(updateRequireLogin({ open: true, updateUser: false }));
            // }

            // if (success) {
            //     success(result, showNotification);
            // }

        }).catch(function (error) {
            callbackError(error);
        }).finally(() => {
            callbackFinally(params);
        });
    };

    React.useEffect(() => {
        return () => setOpen(false);
    }, []);


    return {
        ajax: bind,
        open: open,
        setOpen: setOpen,
        Loading: <Loading open={open} isWarpper={props?.loadingType === 'custom'} circularProps={props?.circularProps} />,
        showNotification: showNotification,
        callbackSuccess: callbackSuccess,
        callbackError: callbackError,
        callbackFinally: callbackFinally,
        requestLogin: requestLogin,
    };
}