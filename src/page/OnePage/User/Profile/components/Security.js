import { Card, CardActions, CardContent, CardHeader, Grid } from '@material-ui/core'
import React from 'react'
import Divider from '@material-ui/core/Divider'
import FieldForm from 'components/FieldForm';
import Button from 'components/Button';
import { __ } from 'utils/i18n';

function Security({ user, setUser, handleSubmit }) {
    return (
        <Card>
            <CardHeader title={__('Security')} />
            <Divider />
            <CardContent>
                <Grid container spacing={3}>
                    <Grid item md={12} sm={12} xs={12}>
                        <Grid container spacing={3}>
                            <Grid item md={4} sm={6} xs={12}>

                                <FieldForm
                                    compoment={'password'}
                                    config={{
                                        title: __('Current Password'),
                                        generator: false,
                                    }}
                                    post={user}
                                    name={'old_password'}
                                    onReview={(value) => {
                                        setUser(prev => ({
                                            ...prev,
                                            old_password: value
                                        }));
                                    }}
                                />

                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item md={4} sm={6} xs={12}>
                        <FieldForm
                            compoment={'password'}
                            config={{
                                title: __('New Password'),
                            }}
                            post={user}
                            name={'password'}
                            onReview={(value) => {
                                setUser(prev => ({
                                    ...prev,
                                    password: value
                                }));
                            }}
                        />
                    </Grid>
                    <Grid item md={4} sm={6} xs={12}>
                        <FieldForm
                            compoment={'password'}
                            config={{
                                title: __('Confirm password'),
                                generator: false,
                                forceRender: true,
                                note: user.confirm_password && user.confirm_password !== user.password ? __('The password confirmation does not match.') : '',
                                error: user.confirm_password && user.confirm_password !== user.password
                            }}
                            post={user}
                            name={'confirm_password'}
                            onReview={(value) => {
                                setUser(prev => ({
                                    ...prev,
                                    confirm_password: value
                                }));
                            }}
                        />
                    </Grid>
                </Grid>
            </CardContent>
            <Divider />
            <CardActions>
                <Button
                    disabled={
                        !user.old_password ||
                        (user.confirm_password && user.confirm_password !== user.password)
                        || user.confirm_password !== user.password
                        || !user.confirm_password
                    }
                    onClick={handleSubmit}
                    color="success"
                    variant="contained">
                    {__('Save Changes')}
                </Button>
            </CardActions>
        </Card>
    )
}

export default Security
