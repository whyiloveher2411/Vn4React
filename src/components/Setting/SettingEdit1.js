import { Box, colors, Divider, Grid, IconButton, makeStyles, Tooltip, Typography } from '@material-ui/core';
import ArrowBackOutlined from '@material-ui/icons/ArrowBackOutlined';
import { Page } from 'components';
import React from 'react';
import { useHistory } from 'react-router-dom';

const useStyles = makeStyles((theme) => ({
    root: {
        '& .btn-green-save': {
            color: theme.palette.buttonSave.contrastText,
            backgroundColor: theme.palette.buttonSave.main,
        },
        '& .btn-green-save:hover': {
            backgroundColor: theme.palette.buttonSave.dark,
        }
    },
    headTop: {
        position: 'sticky',
        top: 0,
        background: theme.palette.body.background,
        zIndex: 2,
        boxShadow: '2px 0px 0 ' + theme.palette.body.background + ', -2px 0px 0 ' + theme.palette.body.background
    },
    divider: {
        backgroundColor: theme.palette.dividerDark,
        margin: '16px 0',
    },
}));

function SettingEdit1({ title, titleComponent, backLink, description, children, width }) {

    const history = useHistory();

    const classes = useStyles();

    return (

        <Page title={title} className={classes.root}>
            <Box display="flex" width={1} justifyContent="center" >
                <div style={{ width: width ?? 660, maxWidth: '100%' }} className={classes.headTop}>
                    <Grid
                        alignItems="flex-end"
                        container
                        justify="space-between"
                        alignItems="center"
                        spacing={3}
                    >
                        <Grid item xs={12} style={{ paddingLeft: 0 }}>
                            <Typography variant="h2" style={{ fontWeight: 'normal' }} color="initial">
                                <Box display="flex" alignItems="center">
                                    {
                                        Boolean(backLink) &&
                                        <Tooltip title="Back" aria-label="back">
                                            <IconButton onClick={() => history.push(backLink)} >
                                                <ArrowBackOutlined />
                                            </IconButton>
                                        </Tooltip>
                                    }
                                    &nbsp; {titleComponent ? titleComponent : title}
                                </Box>
                            </Typography>
                        </Grid>
                    </Grid>
                </div>
            </Box>
            <Divider className={classes.divider} />

            <Box display="flex" justifyContent="center" >

                <div style={{ width: width ?? 660, maxWidth: '100%' }}>
                    {
                        Boolean(description) &&
                        <>
                            <Typography variant="body1">{description}</Typography>
                            <br />
                        </>
                    }
                    {children}
                </div>
            </Box>
        </Page>
    );
}

export default SettingEdit1
