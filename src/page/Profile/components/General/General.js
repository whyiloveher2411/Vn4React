import React, { useState, useEffect } from 'react'
import { makeStyles } from '@material-ui/styles'
import { Grid } from '@material-ui/core'
import { ProfileDetails, GeneralSettings } from './components'

const useStyles = makeStyles(() => ({
    root: {},
}))

const General = ({ user, onReview, handleSubmit }) => {

    const classes = useStyles()
    const [profile, setProfile] = useState(user)

    if (!profile) {
        return null
    }

    return (
        <Grid
            className={classes.root}
            container
            spacing={3}>
            <Grid item lg={4} md={6} xl={3} xs={12}>
                <ProfileDetails profile={profile} onReview={(value, key) => onReview(value, key)} />
            </Grid>
            <Grid item lg={8} md={6} xl={9} xs={12}>
                <GeneralSettings profile={profile} handleSubmit={handleSubmit} onReview={(value, key) => onReview(value, key)} />
            </Grid>
        </Grid>
    )
}

export default General
