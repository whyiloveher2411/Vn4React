import { Grid } from '@material-ui/core'
import React from 'react'
import TodaysMoney from './Dashboard/TodaysMoney';
import NewProjects from './Dashboard/NewProjects';
import SystemHealth from './Dashboard/SystemHealth';
import RoiPerCustomer from './Dashboard/RoiPerCustomer';

function Dashboard() {
    return (
        <>
            <Grid
                item
                lg={3}
                sm={6}
                xs={12}
            >
                <TodaysMoney />
            </Grid>
            <Grid
                item
                lg={3}
                sm={6}
                xs={12}
            >
                <NewProjects />
            </Grid>
            <Grid
                item
                lg={3}
                sm={6}
                xs={12}
            >
                <SystemHealth />
            </Grid>
            <Grid
                item
                lg={3}
                sm={6}
                xs={12}
            >
                <RoiPerCustomer />
            </Grid>
        </>
    )
}

export default Dashboard
