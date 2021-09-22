import { colors, makeStyles, Grid, Typography, Divider } from '@material-ui/core';
import { PageHeaderSticky } from 'components/Page';
import React from 'react';

const useStyles = makeStyles((theme) => {
    return {
        root: {
            flexGrow: 1,
            marginTop: theme.spacing(3),
            '& .btn-green-save': {
                backgroundColor: theme.palette.buttonSave.dark,
                color: theme.palette.buttonSave.contrastText,
            }
        },
    }
});

function SettingScreen1({ title, subTitle, header, children }) {

    const classes = useStyles();
    return (
        <PageHeaderSticky
            title={title}
            header={
                <Grid
                    alignItems="flex-end"
                    container
                    justify="space-between"
                    alignItems="center"
                    spacing={3}>
                    <Grid item xs={12}>
                        {
                            Boolean(header) ?
                                header
                                :
                                <>
                                    <Typography component="h2" gutterBottom variant="overline">{subTitle}</Typography>
                                    <Typography component="h1" variant="h3">
                                        {title}
                                    </Typography>
                                </>
                        }
                    </Grid>
                </Grid>
            }
        >
            <div className={classes.root}>
                {children}
            </div>
        </PageHeaderSticky>
    );
}

export default SettingScreen1
