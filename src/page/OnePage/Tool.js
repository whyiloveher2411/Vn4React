import { Grid, makeStyles, Typography } from '@material-ui/core';
import { Divider, Hook } from 'components';
import { PageHeaderSticky } from 'components/Page';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { __ } from 'utils/i18n';
import { usePermission } from 'utils/user';
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
            margin: theme.spacing(3, 0),
        },
        '& .settingDescription': {
            marginBottom: 8
        }
    },
    title: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between'
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

    const permission = usePermission('tool_management').tool_management;

    if (!permission) {
        return <RedirectWithMessage />
    }

    return (
        <PageHeaderSticky
            title={__('Tools')}
            header={
                <Grid
                    alignItems="flex-end"
                    container
                    className={classes.grid}
                    justify="space-between"
                    alignItems="center"
                    spacing={3}>
                    <Grid item xs={12}>
                        <Typography component="h2" gutterBottom variant="overline">{__('Tools')}</Typography>
                        <Typography component="h1" variant="h3" className={classes.title}>
                            {__('Tool management')}
                        </Typography>
                    </Grid>
                </Grid>
            }
        >
            <div className={classes.root}>

                <Cache />

                <Divider color="dark" className='divider2' />

                <Database />

                <Divider color="dark" className='divider2' />

                <Development />

                <Divider color="dark" className='divider2' />

                <Optimize />

                <Hook hook="Tool" />

            </div>
        </PageHeaderSticky>
    );
}

export default Tool
