import { Divider, makeStyles } from '@material-ui/core'
import React from 'react'

const useStyles = makeStyles(theme => ({
    normal: {
        backgroundColor: theme.palette.divider
    },
    dark: {
        backgroundColor: theme.palette.dividerDark
    }
}));


function DividerCustom({ color, className, ...props }) {

    const classes = useStyles();

    return (
        <Divider {...props} className={(color === 'dark' ? classes.dark : classes.normal) + ' ' + className ?? ''} />
    )
}

export default DividerCustom
