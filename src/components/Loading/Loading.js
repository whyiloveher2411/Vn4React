import React from 'react'
import { makeStyles } from '@material-ui/core/styles';
import { Backdrop, CircularProgress } from '@material-ui/core'
const useStyles = makeStyles((theme) => ({
    root: {
        zIndex: theme.zIndex.drawer + 1,
        color: '#fff',
    },
}));

function Loading({ open, isWarpper, circularProps, ...rest }) {

    const classes = useStyles();

    if (isWarpper) {
        return (open ? <CircularProgress {...circularProps} /> : <></>);
    }

    return (
        <Backdrop className={classes.root} {...rest} open={open}>
            <CircularProgress color="inherit" />
        </Backdrop>
    )
}

export default Loading
