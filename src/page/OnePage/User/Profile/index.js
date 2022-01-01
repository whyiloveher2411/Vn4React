import Typography from '@material-ui/core/Typography'
import { TabsCustom } from 'components'
import { PageHeaderSticky } from 'components/Page'
import RedirectWithMessage from 'components/RedirectWithMessage'
import React from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { Redirect, useHistory, useRouteMatch } from 'react-router-dom'
import { updateInfo } from 'reducers/user'
import { array_flip } from 'utils/helper'
import { __ } from 'utils/i18n'
import { useAjax } from 'utils/useAjax'
import { usePermission } from 'utils/user'
import BasicInformation from './components/BasicInformation'
import Permission from './components/Permission'
import Security from './components/Security'

function Profile() {

    const history = useHistory();
    const match = useRouteMatch();

    const { subtab1 } = match.params;

    const userLogin = useSelector(state => state.user);
    const dispatch = useDispatch();

    const [user, setUser] = React.useState(false);

    const useApi = useAjax();


    const permission = usePermission('my_profile_management').my_profile_management;

    const tabs = [
        { value: 'edit-profile', title: __('Edit Profile'), content: () => <BasicInformation handleSubmit={handleSubmit} user={user} setUser={setUser} /> },
        { value: 'permission', title: __('Permission'), content: () => <Permission handleSubmit={handleSubmit} user={user} setUser={setUser} /> },
        { value: 'security', title: __('Security'), content: () => <Security handleSubmit={handleSubmit} user={user} setUser={setUser} /> },
    ]

    const handleTabsChange = (value) => {
        history.push('/user/profile/' + tabs[value].value)
    }

    let tabContentIndex = tabs.findIndex(item => item.value === subtab1);

    React.useEffect(() => {
        useApi.ajax({
            url: 'user/profile',
            success: (result) => {
                if (result.user) {
                    try {
                        result.user.meta = JSON.parse(result.user.meta) ?? [];
                    } catch (err) {
                        result.user.meta = {};
                    }

                    let permission = result.user.permission;

                    if (permission && !Array.isArray(permission)) {
                        permission = array_flip(permission.split(", "));
                    } else {
                        permission = {};
                    }

                    result.user.permission = permission;
                    setUser(result.user);
                }
            },
        });
    }, []);

    const handleSubmit = () => {
        setUser(prev => {
            useApi.ajax({
                url: 'user/edit',
                method: 'POST',
                data: {
                    ...prev,
                    group: null,
                    permission: Object.keys(prev.permission),

                },
                success: function (result) {
                    if (result.user) {
                        if (userLogin.id === result.user.id) {
                            dispatch(updateInfo(result.user));
                        }
                    }
                }
            });
            return prev;
        });
    };

    if (!permission) {
        return <RedirectWithMessage />
    }

    if (!tabs.find((t) => t.value === subtab1)) {
        return <Redirect to={'/user/profile/' + tabs[0].value} />;
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
                        {user ? (user.first_name + ' ' + user.last_name) : '...'}
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
