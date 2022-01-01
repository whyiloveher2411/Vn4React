import {
    Card, CardActions, CardContent, CardHeader, Divider, Grid
} from '@material-ui/core'
import { FieldForm, Button } from 'components'
import PropTypes from 'prop-types'
import React from 'react'
import { __ } from 'utils/i18n'

const Security = ({ user, setUser, handleSubmit }) => {

    const disabled = !user.password || user.confirm_password !== user.password;

    // const valid = user.password && user.password === user.confirm_password;

    return (
        <Card>
            <CardHeader title={__('Security')} />
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
                            onReview={v => {
                                setUser(prev => ({
                                    ...prev,
                                    password: v
                                }));
                            }}
                        />
                    </Grid>
                    <Grid item md={4} sm={6} xs={12}>
                        <FieldForm
                            compoment={'password'}
                            config={{
                                title: 'Confirm password',
                                forceRender: true,
                                note: user.confirm_password && user.confirm_password !== user.password ? __('The password confirmation does not match.') : '',
                                error: user.confirm_password && user.confirm_password !== user.password
                            }}
                            post={user}
                            name={'confirm_password'}
                            autoComplete="___"
                            onReview={v => {
                                setUser(prev => ({
                                    ...prev,
                                    confirm_password: v
                                }));
                            }}
                        />
                    </Grid>
                </Grid>
            </CardContent>
            <Divider />
            <CardActions>
                <Button
                    disabled={disabled}
                    onClick={handleSubmit}
                    color="success"
                    variant="contained">
                    {__('Save Changes')}
                </Button>
            </CardActions>
        </Card>
    )
}

Security.propTypes = {
    className: PropTypes.string,
}

export default Security
