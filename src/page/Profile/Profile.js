import { colors, Divider, Tab, Tabs } from '@material-ui/core'
import { makeStyles } from '@material-ui/styles'
import { PageHeaderSticky } from 'components/Page'
import RedirectWithMessage from 'components/RedirectWithMessage'
import PropTypes from 'prop-types'
import React from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { Redirect } from 'react-router-dom'
import { checkPermission } from 'utils/user'
import { login } from '../../actions/user'
import { useAjax } from '../../utils/useAjax'
import { General, Header, Permission, Security } from './components'


const useStyles = makeStyles((theme) => ({
    tabs: {
        marginTop: theme.spacing(3),
    },
    content: {
        marginTop: theme.spacing(3),
    },
}))

const Profile = (props) => {

    const { match, history } = props
    const classes = useStyles()
    const { tab } = match.params
    const { ajax } = useAjax();

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
        <PageHeaderSticky title="Profile"
            header={
                <Header profile={user} />
            }
        >
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
            <Divider color="dark" />
            <div className={classes.content}>
                {tab === 'general' && <General shareData={shareData} setShareData={setShareData} user={user} handleSubmit={handleSubmit} onReview={onReview} />}
                {tab === 'permission' && <Permission shareData={shareData} setShareData={setShareData} user={user} handleSubmit={handleSubmit} onReview={onReview} />}
                {tab === 'security' && <Security shareData={shareData} setShareData={setShareData} user={user} handleSubmit={handleSubmit} onReview={onReview} />}
            </div>
        </PageHeaderSticky>
    )
}

Profile.propTypes = {
    history: PropTypes.object.isRequired,
    match: PropTypes.object.isRequired,
}

export default Profile
