import { useSnackbar } from 'notistack';
import React from 'react';
import { useHistory } from 'react-router-dom';

function RedirectWithMessage({ to, message = 'You dont\'t have permission to access on this page', code = 403, variant = 'error' }) {
    const { enqueueSnackbar } = useSnackbar();

    const history = useHistory();

    React.useEffect(() => {
        if (!to) {
            history.push('/error' + code);
        } else {
            history.push(to);
        }
        enqueueSnackbar({ content: message, options: { variant: variant, anchorOrigin: { vertical: 'bottom', horizontal: 'right' } } }, { variant: 'error', anchorOrigin: { vertical: 'bottom', horizontal: 'right' } });
    }, []);

    return null;
    // return <Redirect to={to} />
}

export default RedirectWithMessage
