import React from 'react'
import { Redirect } from 'react-router-dom'
import PropTypes from 'prop-types'
import { makeStyles } from '@material-ui/styles'
import { Tabs, Tab, Divider, colors } from '@material-ui/core'

import { Page } from '../../components'

import { useDispatch, useSelector } from 'react-redux';
import { login } from '../../actions/user';
import { useAjax } from '../../utils/useAjax';
import { General, Header, History, Permission, Security } from './components'
import { checkPermission } from 'utils/user'
import RedirectWithMessage from 'components/RedirectWithMessage'


const useStyles = makeStyles((theme) => ({
    tabs: {
        marginTop: theme.spacing(3),
    },
    divider: {
        backgroundColor: colors.grey[300],
    },
    content: {
        marginTop: theme.spacing(3),
    },
}))

const Profile = (props) => {

    const { match, history } = props
    const classes = useStyles()
    const { tab } = match.params
    const {ajax} = useAjax();

    let user = useSelector(state => state.user);

    const [shareData, setShareData] = React.useState({});
    const permission = checkPermission('my_profile_management');

    const onReview = (value, key) => {
        user[key] = value;
        console.log(user);
    };

    const handleTabsChange = (event, value) => {
        history.push(value)
    }

    const tabs = [
        { value: 'general', label: 'General' },
        { value: 'permission', label: 'Permission' },
        { value: 'security', label: 'Security' },
    ]

    const dispatch = useDispatch();

    const handleSubmit = () => {
        ajax({
            url: 'profile/post',
            method: 'POST',
            data: user,
            isGetData: false,
            success: function (result) {
                if (result.user) {

                    if (user.id === result.user.id) {
                        dispatch(login(result.user));
                    }
                }

                // dispatch(login(result.user));
            }
        });
    };

    if (!permission) {
        return <RedirectWithMessage />
    }
    if (!tabs.find((t) => t.value === tab)) {
        return <Redirect to="/users/profile/general" />
    }

    return (
        <Page title="Profile">
            <Header profile={user} />
            <Tabs
                className={classes.tabs}
                onChange={handleTabsChange}
                scrollButtons="auto"
                value={tab}
                indicatorColor="primary"
                textColor="primary"
                variant="scrollable">
                {tabs.map((tab) => (
                    <Tab key={tab.value} label={tab.label} value={tab.value} />
                ))}
            </Tabs>
            <Divider className={classes.divider} />
            <div className={classes.content}>
                {tab === 'general' && <General shareData={shareData} setShareData={setShareData} user={user} handleSubmit={handleSubmit} onReview={onReview} />}
                {tab === 'permission' && <Permission shareData={shareData} setShareData={setShareData} user={user} handleSubmit={handleSubmit} onReview={onReview} />}
                {tab === 'security' && <Security shareData={shareData} setShareData={setShareData} user={user} handleSubmit={handleSubmit} onReview={onReview} />}
            </div>
        </Page>
    )
}

Profile.propTypes = {
    history: PropTypes.object.isRequired,
    match: PropTypes.object.isRequired,
}

export default Profile
