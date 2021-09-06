import React, { useState } from 'react'
import PropTypes from 'prop-types'
import { makeStyles } from '@material-ui/styles'
import {
    Card,
    CardHeader,
    CardContent,
    CardActions,
    Grid,
    Button,
    Divider,
    TextField,
    colors,
} from '@material-ui/core'
import FieldForm from 'components/FieldForm';


const useStyles = makeStyles((theme) => ({
    root: {},
    saveButton: {
        color: theme.palette.white,
        backgroundColor: colors.green[600],
        '&:hover': {
            backgroundColor: colors.green[900],
        },
    },
}))

const Security = (props) => {
    const { className, user, setShareData, shareData, handleSubmit, onReview, ...rest } = props

    const classes = useStyles()

    const [values, setValues] = useState({
        old_password: setShareData.security?.old_password,
        password: setShareData.security?.password,
        confirm: setShareData.security?.confirm,
    });

    const [render, setRender] = React.useState(0);

    const handleChange = (key, value) => {

        setShareData(prev2 => ({
            ...prev2, security: {
                ...setShareData.security,
                [key]: value,
            }
        }))

        setValues(prev => ({
            ...prev,
            [key]: value,
        }))

        console.log({
            ...values,
            [key]: value,
        })
    }

    const handleSubmitPassword = () => {

        if ((values.old_password) && (values.password && values.password === values.confirm && values.confirm)) {
            user['password_' + user.id] = values.password;
            user['old_password'] = values.old_password;
            handleSubmit();
        }


    }
    return (
        <Card {...rest} className={classes.root}>
            <CardHeader title="Change password" />
            <Divider />
            <CardContent>
                <Grid container spacing={3}>
                    <Grid item md={12} sm={12} xs={12}>
                        <Grid container spacing={3}>
                            <Grid item md={4} sm={6} xs={12}>

                                <FieldForm
                                    compoment={'password'}
                                    config={{
                                        title: 'Current Password',
                                        generator: false
                                    }}
                                    post={values}
                                    name={'old_password'}
                                    onReview={(value) => handleChange('old_password', value)}
                                />

                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item md={4} sm={6} xs={12}>
                        <FieldForm
                            compoment={'password'}
                            config={{
                                title: 'New Password',
                            }}
                            post={values}
                            name={'password'}
                            onReview={(value) => handleChange('password', value)}
                        />
                    </Grid>
                    <Grid item md={4} sm={6} xs={12}>
                        <FieldForm
                            compoment={'password'}
                            config={{
                                title: 'Confirm password',
                                generator: false
                            }}
                            post={values}
                            name={'confirm'}
                            onReview={(value) => handleChange('confirm', value)}
                        />
                    </Grid>
                </Grid>
            </CardContent>
            <Divider />
            <CardActions>
                <Button
                    className={classes.saveButton}
                    disabled={!((values.old_password) && (values.password && values.password === values.confirm && values.confirm))}
                    onClick={handleSubmitPassword}
                    variant="contained">
                    Save changes
                </Button>
            </CardActions>
        </Card>
    )
}

Security.propTypes = {
    className: PropTypes.string,
}

export default Security
