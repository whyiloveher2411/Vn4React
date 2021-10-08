import React from 'react';
import { makeStyles } from '@material-ui/styles';
import { Grid } from '@material-ui/core';
import { Page, Hook } from 'components';
import Header from './Dashboard/Header';
import { __ } from 'utils/i18n';

const useStyles = makeStyles(theme => ({
    root: {
        padding: theme.spacing(3)
    },
    container: {
        marginTop: theme.spacing(3)
    }
}));

const Dashboard = () => {
    const classes = useStyles();

    return (
        <Page
            width='xl'
            title={__("Dashboard")}
        >
            <Header />
            <Grid
                className={classes.container}
                container
                spacing={3}
            >
                <Hook hook="Dashboard/Main" />
            </Grid>
        </Page>
    );
};

export default Dashboard;
