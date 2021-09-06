import React from 'react'
import { Redirect } from 'react-router-dom'
import { makeStyles } from '@material-ui/styles'
import { Tabs, Tab, Divider, colors } from '@material-ui/core'

import { Page } from '../../../../components'

import { useSelector } from 'react-redux';
import { useAjax } from '../../../../utils/useAjax';
import { General, Header, Permission, Security } from './components'


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

    const classes = useStyles()

    const { data } = props;

    const [tab, setTab] = React.useState('general');

    const { ajax } = useAjax();


    let userLogin = useSelector(state => state.user);

    const [user, setUser] = React.useState(data.post ?? {});

    const [shareData, setShareData] = React.useState({});

    const onReview = (value, key) => {
        user[key] = value;
        setUser({ ...user });
    };

    React.useEffect(() => {
        setUser(data.post ?? {});
        setTab('general');
    }, [data]);

    const handleTabsChange = (event, value) => {
        setTab(value);
    }

    const tabs = [
        { value: 'general', label: 'General' },
        { value: 'permission', label: 'Permission' },
        { value: 'security', label: 'Security' },
    ]

    const handleSubmit = () => {

        if (props.data.action === 'ADD_NEW') {
            ajax({
                url: 'profile/add-new',
                method: 'POST',
                data: user,
                success: function (result) {
                    if (result.user) {
                        props.history.push(`/post-type/${data.type}/list?redirectTo=edit&post=${result.user.id}`);
                    }
                }
            });
        } else {
            ajax({
                url: 'profile/edit-user',
                method: 'POST',
                data: user,
                success: function (result) {
                    // localStorage.setItem("user", JSON.stringify(result.user));
                    // dispatch(login(result.user));
                }
            });
        }
    };

    if (!user) {
        return null;
    }

    if (user.id === userLogin.id) {
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
                {tab === 'general' && <General action={props.data.action} shareData={shareData} setShareData={setShareData} user={user} handleSubmit={handleSubmit} onReview={onReview} />}
                {tab === 'permission' && <Permission action={props.data.action} shareData={shareData} setShareData={setShareData} user={user} handleSubmit={handleSubmit} onReview={onReview} />}
                {tab === 'security' && <Security action={props.data.action} shareData={shareData} setShareData={setShareData} user={user} handleSubmit={handleSubmit} onReview={onReview} />}
            </div>
        </Page>
    )
}

export default Profile
