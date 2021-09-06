import { Button, Typography, useMediaQuery, useTheme } from '@material-ui/core';
import { makeStyles } from '@material-ui/styles';
import React from 'react';
import { Link as RouterLink } from 'react-router-dom';

const useStyles = makeStyles(theme => ({
    root: {
        padding: theme.spacing(3),
        paddingTop: '10vh',
        display: 'flex',
        flexDirection: 'column',
        alignContent: 'center'
    },
    imageContainer: {
        marginTop: theme.spacing(6),
        display: 'flex',
        justifyContent: 'center'
    },
    image: {
        maxWidth: '100%',
        width: 560,
        maxHeight: 300,
        height: 'auto'
    },
    buttonContainer: {
        marginTop: theme.spacing(6),
        display: 'flex',
        justifyContent: 'center'
    }
}));


function CommingSoon() {

    const classes = useStyles();
    const theme = useTheme();
    const mobileDevice = useMediaQuery(theme.breakpoints.down('sm'));

    return (
        <div className={classes.root}>
            <Typography
                align="center"
                variant={mobileDevice ? 'h4' : 'h1'}
            >
                Something awesome is coming!
            </Typography>
            <Typography
                align="center"
                variant="subtitle2"
            >
                We are working very hard on the new version of our site. It will bring a lot of new features. Stay tuned!
            </Typography>
            <div className={classes.imageContainer}>
                <img
                    alt="Under development"
                    className={classes.image}
                    src="/images/undraw_work_chat_erdt.svg"
                />
            </div>
            <div className={classes.buttonContainer}>
                <Button
                    color="primary"
                    component={RouterLink}
                    to="/"
                    variant="outlined"
                >
                    Back to home
                </Button>
            </div>
        </div>
    )
}

export default CommingSoon
