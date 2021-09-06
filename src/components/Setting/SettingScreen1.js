import { colors, makeStyles, Grid, Typography, Divider } from '@material-ui/core';
import { Page } from 'components';
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
    }
});

function SettingScreen1({ title, subTitle, header, children }) {

    const classes = useStyles();
    return (
        <Page title={title}>
            <div className={classes.headTop}>
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
                <Divider className={classes.divider} />
            </div>
            {
                <div className={classes.root}>
                    {children}
                </div>
            }
        </Page>
    );
}

export default SettingScreen1
