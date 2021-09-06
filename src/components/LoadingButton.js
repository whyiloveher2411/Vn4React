import React from 'react'
import CircularProgress from '@material-ui/core/CircularProgress';
import Button from '@material-ui/core/Button';

function LoadingButton({ children, startIcon, open, ...props }) {
    return (
        <Button
            variant="contained"
            color="primary"
            startIcon={open ? <CircularProgress size={18} color={'inherit'} /> : (startIcon ? startIcon : null)}
            {...props}
        >
            {children}
        </Button>
    )
}

export default LoadingButton
