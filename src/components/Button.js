import { makeStyles, Button } from '@material-ui/core';
import React from 'react'

const useStyles = makeStyles((theme) => ({
    colorGreen: {
        color: theme.palette.success.contrastText,
        backgroundColor: theme.palette.success.main,
        '&:hover': {
            backgroundColor: theme.palette.success.dark,
        },
    },
}));


function ButtonCustom({ children, className, color, ...props }) {

    const classes = useStyles();

    return (
        <Button
            {...props}
            color={color !== 'success' ? color : 'default'}
            className={className + ' ' + (color === 'success' ? classes.colorGreen : '')}
        >
            {children}
        </Button>
    )
}

export default ButtonCustom
