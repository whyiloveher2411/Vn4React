import { colors, Divider, Grid, makeStyles, Typography } from '@material-ui/core';
import { Hook, Page } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { checkPermission } from 'utils/user';
import Cache from './Tool/Cache';
import Database from './Tool/Database';
import Development from './Tool/Development';
import Optimize from './Tool/Optimize';

const useStyles = makeStyles((theme) => ({
    root: {
        flexGrow: 1,
        marginTop: theme.spacing(3),
        '& .settingTitle2': {
            fontSize: 16,
            margin: '10px 0 10px',
        },
        '& .margin': {
            marginTop: theme.spacing(1),
        },
        '& .divider2': {
            backgroundColor: colors.grey[300],
            margin: '24px 0',
        }
    },
    headTop: {
        position: 'sticky',
        top: 0,
        background: '#f4f6f8',
        zIndex: 2,
        boxShadow: '2px 0px 0 #f4f6f8, -2px 0px 0 #f4f6f8'
    },
    title: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between'
    },
    divider: {
        backgroundColor: colors.grey[300],
        margin: '16px 0',
    },

    saveButton: {
        color: theme.palette.white,
        backgroundColor: colors.green[600],
        '&:hover': {
            backgroundColor: colors.green[900],
        },
    },
    tabs: {
        position: 'sticky',
        top: 0,
        backgroundColor: '#f4f6f8',
        zIndex: 2
    },

    heading: {
        fontSize: theme.typography.pxToRem(15),
    },
    secondaryHeading: {
        fontSize: theme.typography.pxToRem(15),
        color: theme.palette.text.secondary,
    },
    icon: {
        verticalAlign: 'bottom',
        height: 20,
        width: 20,
    },
    details: {
        alignItems: 'center',
    },
    column: {
        flexBasis: '33.33%',
        '& .MuiChip-root': {
            marginRight: 4
        }
    },
    helper: {
        borderLeft: `2px solid ${theme.palette.divider}`,
        padding: theme.spacing(1, 2),
    },
    link: {
        color: theme.palette.primary.main,
        textDecoration: 'none',
        '&:hover': {
            textDecoration: 'underline',
        },
    },
}));

function Tool() {

    const classes = useStyles();

    const permission = checkPermission('tool_management');

    if (!permission) {
        return <RedirectWithMessage />
    }

    return (
        <Page title="Vn4 SEO">
            <div className={classes.headTop}>
                <Grid
                    alignItems="flex-end"
                    container
                    className={classes.grid}
                    justify="space-between"
                    alignItems="center"
                    spacing={3}>
                    <Grid item xs={12}>
                        <Typography component="h2" gutterBottom variant="overline">Tool</Typography>
                        <Typography component="h1" variant="h3" className={classes.title}>
                            Tool management
                        </Typography>
                    </Grid>
                </Grid>
                <Divider className={classes.divider} />
            </div>
            <div className={classes.root}>

                <Cache />

                <Divider className='divider2' />

                <Database />

                <Divider className='divider2' />

                <Development />

                <Divider className='divider2' />

                <Optimize />

                <Hook hook="Tool" />

            </div>
        </Page>
    );
}

export default Tool
