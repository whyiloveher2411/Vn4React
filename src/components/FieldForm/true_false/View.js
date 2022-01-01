import { makeStyles } from "@material-ui/core";

const useStyles = makeStyles((theme) => ({
    pointSelect: {
        marginBottom: 2,
        display: 'inline-block',
        width: 6,
        height: 6,
        marginRight: 6,
        borderRadius: '50%',
    },
    chooseTrue: {
        backgroundColor: theme.palette.success.main,
    },
    chooseFalse: {
        backgroundColor: theme.palette.secondary.main,
    }

}))

function View(props) {

    const classes = useStyles();

    if (props.content) {
        if (props.config.labels) {
            return <><span className={classes.pointSelect + ' ' + classes.chooseTrue}></span>{props.config.labels[1]}</>
        }

        return <><span className={classes.pointSelect + ' ' + classes.chooseTrue}></span>True</>
    }

    if (props.config.labels) {
        return <><span className={classes.pointSelect + ' ' + classes.chooseFalse}></span>{props.config.labels[0]}</>
    }
    return <><span className={classes.pointSelect + ' ' + classes.chooseFalse}></span>False</>
}

export default View
