import { Grid, Typography, Divider, makeStyles, colors } from '@material-ui/core'
import React from 'react'


const useStyles = makeStyles((theme) => ({
    headTop: {
        position: 'sticky',
        top: 0,
        background: '#f4f6f8',
        zIndex: 2,
        boxShadow: '2px 0px 0 #f4f6f8, -2px 0px 0 #f4f6f8'
    },
    divider: {
        backgroundColor: colors.grey[300],
        margin: '16px 0',
    },
}));

function Header({ children }) {

    const classes = useStyles();

    return (
        <div className={classes.headTop}>
            <Grid
                alignItems="flex-end"
                container
                justify="space-between"
                alignItems="center"
                spacing={3}>
                <Grid item xs={12}>
                    {
                        Boolean(children) ?
                            children
                            :
                            <>
                                <Typography component="h2" gutterBottom variant="overline">Vn4SEO</Typography>
                                <Typography component="h1" variant="h3">
                                    Settings
                                </Typography>
                            </>
                    }
                </Grid>
            </Grid>
            <Divider className={classes.divider} />
        </div>
    )
}

export default Header
