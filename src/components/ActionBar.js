import Typography from '@material-ui/core/Typography'
import Hidden from '@material-ui/core/Hidden'
import Grid from '@material-ui/core/Grid'
import Drawer from '@material-ui/core/Drawer'
import { makeStyles } from '@material-ui/styles'
import React from 'react'

const useStyles = makeStyles((theme) => ({
    shadow: {
        '& .MuiDrawer-paperAnchorDockedBottom': {
            boxShadow: '0px -2px 4px -1px rgb(0 0 0 / 20%), 0px -4px 5px 0px rgb(0 0 0 / 14%), 0px -1px 10px 0px rgb(0 0 0 / 12%)',
        }
    },
    root: {
        padding: theme.spacing(2),
    },
    actions: {
        display: 'flex',
        justifyContent: 'center',
        flexWrap: 'wrap',
        gap: theme.spacing(1),
        '& > * + *': {
            marginLeft: theme.spacing(2),
        },
    },
}))

const ActionBar = (props) => {
    const {
        selected,
        actions,
        ...rest
    } = props

    const classes = useStyles()
    const open = selected.length > 0;

    return (
        <>
            <Drawer
                anchor="bottom"
                open={open}
                // eslint-disable-next-line react/jsx-sort-props
                PaperProps={{ elevation: 1 }}
                className={classes.shadow}
                variant="persistent">
                <div {...rest} className={classes.root}>
                    <Grid alignItems="center" container spacing={2}>
                        <Hidden smDown>
                            <Grid item md={3}>
                                <Typography
                                    color="textSecondary"
                                    variant="subtitle1">
                                    {selected.length} selected
                                </Typography>
                            </Grid>
                        </Hidden>
                        <Grid item md={6} xs={12}>
                            <div className={classes.actions}>
                                {actions}
                            </div>
                        </Grid>
                    </Grid>
                </div>
            </Drawer>
        </>
    )
}

export default ActionBar
