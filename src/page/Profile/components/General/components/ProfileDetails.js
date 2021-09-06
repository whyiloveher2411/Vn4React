import React from 'react'
import PropTypes from 'prop-types'
import { makeStyles } from '@material-ui/styles'
import { Card, CardContent, Typography, } from '@material-ui/core'
import FieldForm from 'components/FieldForm';

const useStyles = makeStyles((theme) => ({
    root: {},
    content: {
        display: 'flex',
        alignItems: 'center',
        flexDirection: 'column',
        textAlgin: 'center',
    },
    name: {
        marginTop: theme.spacing(1),
    },
    avatar: {
        height: 100,
        width: 100,
    },
    removeBotton: {
        width: '100%',
    },
}))

const ProfileDetails = (props) => {
    const { profile, onReview, ...rest } = props


    let avataIntial = {};

    try {
        if (profile.profile_picture) {
            if (typeof profile.profile_picture === 'object') {
                avataIntial = profile.profile_picture;
            } else {
                avataIntial = JSON.parse(profile.profile_picture);
            }
        }
    } catch (error) {

    }


    const [avata, setAvata] = React.useState(avataIntial);

    console.log(profile);

    const classes = useStyles()

    return (
        <Card {...rest} className={classes.root}>
            <CardContent className={classes.content}>
                <div>
                    <FieldForm
                        compoment={'image'}
                        config={{
                            title: 'Avata',
                        }}
                        post={{ avata: avata }}
                        name={'avata'}
                        onReview={value => onReview(value, 'profile_picture')}
                    />
                </div>
                <Typography className={classes.name} gutterBottom variant="h3">
                    {profile.first_name} {profile.last_name}
                </Typography>

            </CardContent>
        </Card>
    )
}

ProfileDetails.propTypes = {
    profile: PropTypes.object.isRequired,
}

export default ProfileDetails
