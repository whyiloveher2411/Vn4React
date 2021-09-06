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
import { FieldForm } from 'components'

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
    const { className, user, handleSubmit, onReview, ...rest } = props

    const classes = useStyles()

    const handleSubmitPassword = () => {
        if (valid) {
            handleSubmit();
        }
    }

    const valid = user._password && user._password === user._confirm_password;

    return (
        <Card {...rest} className={classes.root}>
            <CardHeader title="Password" />
            <Divider />
            <CardContent>
                <Grid container spacing={3}>
                    <Grid item md={4} sm={6} xs={12}>
                        <FieldForm
                            compoment={'password'}
                            config={{
                                title: 'Password',
                            }}
                            post={user}
                            name={'password'}
                            autoComplete="___"
                            onReview={v => onReview(v, '_password')}
                        />
                    </Grid>
                    <Grid item md={4} sm={6} xs={12}>

                        <FieldForm
                            compoment={'password'}
                            config={{
                                title: 'Confirm password',
                            }}
                            post={user}
                            name={'confirm_password'}
                            autoComplete="___"
                            onReview={v => onReview(v, '_confirm_password')}
                        />

                        {/* <TextField
                            fullWidth
                            label="Confirm password"
                            name="confirm"
                            onChange={handleChange}
                            type="password"
                            value={values.confirm}
                            variant="outlined"
                        /> */}
                    </Grid>
                </Grid>
            </CardContent>
            <Divider />
            <CardActions>
                <Button
                    className={classes.saveButton}
                    disabled={!valid}
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
