import {
    Card, CardActions, CardContent, CardHeader, Divider, Grid
} from '@material-ui/core'
import { FieldForm, Button } from 'components'
import PropTypes from 'prop-types'
import React from 'react'

const Security = (props) => {
    const { user, handleSubmit, onReview, ...rest } = props

    const handleSubmitPassword = () => {
        if (valid) {
            handleSubmit();
        }
    }

    const valid = user._password && user._password === user._confirm_password;

    return (
        <Card {...rest}>
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
                    disabled={!valid}
                    onClick={handleSubmitPassword}
                    color="success"
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
