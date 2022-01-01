import Typography from '@material-ui/core/Typography'
import { TabsCustom } from 'components'
import { PageHeaderSticky } from 'components/Page'
import RedirectWithMessage from 'components/RedirectWithMessage'
import React from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { Redirect, useHistory, useRouteMatch } from 'react-router-dom'
import { array_flip } from 'utils/helper'
import { __ } from 'utils/i18n'
import { useAjax } from 'utils/useAjax'
import { usePermission } from 'utils/user'
import BasicInformation from './../../../OnePage/User/Profile/components/BasicInformation'
import Permission from './../../../OnePage/User/Profile/components/Permission'
import Security from './components/Security'

function Profile(props) {

    const history = useHistory();
    const match = useRouteMatch();

    const { data } = props;

    const { subtab1 } = match.params;

    const userLogin = useSelector(state => state.user);
    const dispatch = useDispatch();

    const [user, setUser] = React.useState(false);

    const useApi = useAjax();

    const permission = usePermission('my_profile_management').my_profile_management;

    const tabs = [
        { value: 'edit-profile', title: __('Edit Profile'), content: () => <BasicInformation enableEmail={true} handleSubmit={handleSubmit} user={user} setUser={setUser} /> },
        { value: 'permission', title: __('Permission'), content: () => <Permission handleSubmit={handleSubmit} user={user} setUser={setUser} /> },
        { value: 'security', title: __('Security'), content: () => <Security handleSubmit={handleSubmit} user={user} setUser={setUser} /> },
    ]

    const handleTabsChange = (value) => {
        // history.push(tabs[value].value)
    }

    let tabContentIndex = tabs.findIndex(item => item.value === subtab1);

    React.useEffect(() => {

        let dataUser = props.data.post;

        try {
            dataUser.meta = JSON.parse(dataUser.meta) ?? [];
        } catch (err) {
            dataUser.meta = {};
        }

        let permission = dataUser.permission;

        if (permission && !Array.isArray(permission)) {
            permission = array_flip(permission.split(", "));
        } else {
            permission = {};
        }

        dataUser.permission = permission;

        setUser(dataUser);

    }, []);

    const handleSubmit = () => {

        setUser(prev => {

            // if (props.data.action === 'ADD_NEW') {
            useApi.ajax({
                url: 'user/edit',
                method: 'POST',
                data: {
                    ...prev,
                    group: null,
                    permission: Object.keys(prev.permission),
                },
                success: function () {

                }
            });
           
            return prev;

        });
    };

    if (!permission) {
        return <RedirectWithMessage />
    }

    if (userLogin.id === data.post.id) {
        return <Redirect to={'/user/profile'} />;
    }

    if (!user) {
        return <></>;
    }

    return (
        <PageHeaderSticky title="Profile"
            header={
                <>
                    <Typography component="h2" gutterBottom variant="overline">
                        User settings
                    </Typography>
                    <Typography component="h1" variant="h3">
                        {props.data.action === 'ADD_NEW' ? __('New user') : __('Edit User')}
                    </Typography>
                </>
            }
        >

            <TabsCustom
                name={'user/profile'}
                tabIndex={tabContentIndex}
                onChangeTab={handleTabsChange}
                tabs={tabs}
            />
        </PageHeaderSticky>
    )
}

export default Profile
