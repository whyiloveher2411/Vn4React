import { useSnackbar, VariantType } from 'notistack';
import React from 'react';
import Loading from '../components/Loading';

const urlPrefixDefault = process.env.REACT_APP_BASE_URL;

export default function useApi(props) {

    const [open, setOpen] = React.useState(false);

    const { enqueueSnackbar } = useSnackbar();

    const showNotification = (content, type = 'error') => {

        if (typeof content === 'string') {
            enqueueSnackbar(content, { variant: type, anchorOrigin: { vertical: 'bottom', horizontal: 'right' } });
            return;
        }

        if (content.content) {
            enqueueSnackbar(content, content.options);
        }
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

    const bind = async (params) => {

        let { url, urlPrefix = null, headers = {
            'Content-Type': 'application/json',
        }, method = 'POST', data = null, loading = true } = params;

        if (loading) {
            setOpen(true);
        }

        let paramForFetch = {
            headers: headers,
            method: method,
        };

        if (data) {
            paramForFetch['body'] = JSON.stringify(data);
        }

        const respon = await fetch((urlPrefix ?? urlPrefixDefault) + url, paramForFetch)
            .then(async (response) => {
                return await response.json();
            }).catch(function (error) {
                callbackError(error);
            }).finally(() => {
                callbackFinally(params);
            });

        return respon;

    };

    React.useEffect(() => {
        return () => setOpen(false);
    }, []);


    return {
        fetch: bind,
        open: open,
        setOpen: setOpen,
        Loading: <Loading open={open} isWarpper={props?.loadingType === 'custom'} circularProps={props?.circularProps} />,
        showNotification: showNotification,
        callbackError: callbackError,
        callbackFinally: callbackFinally,
    };
}