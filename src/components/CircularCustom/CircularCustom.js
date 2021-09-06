import React from 'react'
import { makeStyles } from '@material-ui/styles'
import { CircularProgress } from '@material-ui/core';


const useStyles = makeStyles((theme) => ({
    root: {
        position: 'absolute',
        left: 0,
        right: 0,
        top: 0,
        height: '100%',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
    },
    bottom: {
        color: theme.palette.grey[theme.palette.type === 'light' ? 200 : 700],
        position: 'absolute',
    },
    circle: {
        strokeLinecap: 'round',
    },
}));


function CircularCustom(props) {
    const classes = useStyles();
    return (
        <div className={classes.root} style={{ background: props.bg ?? 'transparent' }} {...props}>
            <CircularProgress
                variant="determinate"
                className={classes.bottom}
                size={40}
                thickness={4}
                value={100}
            />
            <CircularProgress
                variant="indeterminate"
                disableShrink
                className={classes.top}
                classes={{
                    circle: classes.circle,
                }}
                size={40}
                thickness={4}
            />
        </div>
    )
}

export default CircularCustom
