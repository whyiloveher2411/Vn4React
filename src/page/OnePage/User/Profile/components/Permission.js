import { Box, ButtonGroup, Card, CardContent, CardHeader, Checkbox, FormControl, FormControlLabel, Grid, IconButton, Typography } from '@material-ui/core';
import React from 'react'
import { useAjax } from 'utils/useAjax';
import Divider from '@material-ui/core/Divider'
import { __ } from 'utils/i18n';
import Button from 'components/Button';
import FieldForm from 'components/FieldForm';
import { makeStyles } from '@material-ui/styles';
import VisibilityRoundedIcon from '@material-ui/icons/VisibilityRounded';
import { Skeleton } from '@material-ui/lab';
import { addClasses } from 'utils/dom';

function Permission({ user, setUser, handleSubmit }) {

    const classes = useStyles();
    const useApi = useAjax();

    React.useEffect(() => {
        if (!user.group) {
            useApi.ajax({
                url: 'user/permission',
                method: 'POST',
                success: function (result) {
                    if (result.permissions) {
                        validateGroupPermissions(result.permissions, user);
                        setUser(prev => ({
                            ...prev,
                            group: result.permissions
                        }))
                    }
                }
            });

        }
    }, []);

    const handleChangePermission = (permission) => (e) => {
        setUser((prev) => {
            if (prev.permission.hasOwnProperty(permission)) {
                delete prev.permission[permission];
            } else {
                prev.permission[permission] = true;
            }
            let group = prev.group;
            validateGroupPermissions(group, prev, false);
            prev.group = group;
            return { ...prev };
        });
    };

    const handleChangeGroupPermission = (group) => {
        setUser((prev) => {
            let { permission, onlyShowGroupSelected } = validateGroupPermissions(group, prev, true);
            return { ...prev, permission: permission, group: group, onlyShowGroupSelected: onlyShowGroupSelected };
        });
    }

    const handleChangeShowGranted = (type) => () => {
        setUser(prev => ({ ...prev, showGrantedType: type }))
    }

    if (user.group) {
        return (
            <Card>
                <CardHeader title={
                    <Box display="flex" alignItems="center" gridGap={8}>
                        <div style={{ width: 150, display: 'inline-block' }}>
                            <FieldForm
                                compoment={'select'}
                                config={{
                                    title: 'Role',
                                    list_option: {
                                        custom: { title: '--Custom--' },
                                        ['Super Admin']: { title: 'Super Admin' },
                                    },
                                    size: 'small',
                                    disableClearable: true,
                                }}
                                post={{
                                    role: !user.role ? 'custom' : user.role,
                                }}
                                name={'role'}
                                onReview={value => {
                                    setUser(prev => ({
                                        ...prev,
                                        role: value === 'custom' ? '' : value,
                                    }));
                                }}
                            />
                        </div>
                        <Button
                            type="submit"
                            onClick={handleSubmit}
                            color="success"
                            variant="contained">
                            {__('Save Changes')}
                        </Button>
                    </Box>
                }
                />
                <Divider />
                <CardContent
                    style={{ padding: 16 }}
                    className={addClasses({
                        [classes.disable]: Boolean(user.role)
                    })}>
                    <Grid container spacing={4} >
                        <Grid className={classes.borderStyle} style={{ display: 'flex', alignItems: 'center', borderRight: '1px solid #dedede', borderBottom: '1px solid #dedede' }} item md={4} xs={12} >
                            <Typography variant='h5'>{__('Group (Granted/Total)')}</Typography>
                        </Grid>
                        <Grid className={classes.borderStyle} style={{ borderBottom: '1px solid #dedede', display: 'flex' }} item md={8} xs={12}>

                            <div>
                                <ButtonGroup aria-label="outlined button group">
                                    <Button
                                        onClick={handleChangeShowGranted(0)}
                                        color={!user.showGrantedType ? 'primary' : 'default'}
                                    >
                                        {__('All')}
                                    </Button>
                                    <Button
                                        onClick={handleChangeShowGranted(1)}
                                        color={user.showGrantedType === 1 ? 'primary' : 'default'}
                                    >
                                        {__('Granted Only')}
                                    </Button>
                                    <Button
                                        onClick={handleChangeShowGranted(2)}
                                        color={user.showGrantedType === 2 ? 'primary' : 'default'}
                                    >
                                        {__('Not Granted')}
                                    </Button>
                                </ButtonGroup>
                            </div>

                            {/* <FormControlLabel
                                control={<Checkbox color='primary' checked={user.activeGrantedOnly ? true : false} onClick={e => {
                                    setUser(prev => ({ ...prev, activeGrantedOnly: !user.activeGrantedOnly }))
                                }} />}
                                label={__('Granted Only')}
                            /> */}
                        </Grid>
                        <Grid className={classes.groupPermission + ' custom_scroll'} item md={4} xs={12}>
                            <GroupPermission
                                group={user.group}
                                handleChangeGroupPermission={handleChangeGroupPermission}
                                user={user}
                                setUser={setUser}
                            />
                        </Grid>
                        <Grid item md={8} xs={12} className={classes.permission + ' custom_scroll'}>
                            <Grid container spacing={4} style={{ paddingTop: 12 }}>
                                <PermissionItems
                                    user={user}
                                    group={user.group}
                                    handleChangePermission={handleChangePermission}
                                    onlyShowGroupSelected={user.onlyShowGroupSelected}
                                />
                            </Grid>
                        </Grid>
                    </Grid>

                </CardContent>
            </Card>
        )
    }

    return (
        <Card>
            <CardContent>
                <Box display="flex" alignItems="center" gridGap={8}>
                    <Skeleton animation="wave" height={24} width={150} />
                    <Skeleton animation="wave" height={24} width={130} />
                </Box>
                <Grid container spacing={4}>
                    <Grid className={classes.borderStyle} style={{ borderRight: '1px solid #dedede', borderBottom: '1px solid #dedede' }} item md={4} xs={12}>
                        <Skeleton animation="wave" height={24} style={{ marginBottom: 10, marginTop: 16 }} />
                    </Grid>
                    <Grid className={classes.borderStyle} style={{ borderBottom: '1px solid #dedede', display: 'flex' }} item md={8} xs={12}>
                        <Skeleton animation="wave" height={24} style={{ marginBottom: 10, marginTop: 16, width: '100%' }} />
                    </Grid>
                    <Grid className={classes.borderStyle} style={{ borderRight: '1px solid #dedede' }} item md={4} xs={12}>
                        {
                            (() => {
                                const options = [];
                                for (let i = 0; i < 14; i++) {
                                    options.push(<Skeleton key={i} animation="wave" height={16} style={{ marginBottom: 14 }} />);
                                }
                                return options;
                            })()
                        }
                    </Grid>
                    <Grid item md={8} xs={12}>
                        <Grid container spacing={4} style={{ paddingTop: 12 }}>
                            {
                                (() => {
                                    const options = [];

                                    for (let i = 0; i < 42; i++) {
                                        options.push(<Grid key={i} style={{ paddingTop: 4, paddingBottom: 4 }} item md={4} xs={12}>
                                            <Skeleton animation="wave" height={16} style={{ marginBottom: 6 }} />
                                        </Grid>);
                                    }

                                    return options;
                                })()
                            }
                        </Grid>
                    </Grid>
                </Grid>
            </CardContent>
        </Card>
    )
}

function validateGroupPermissions(groupPermissions, user, withChangePermission = false, onlyShowGroupSelected = false) {

    let checkSum = 0, notCheckSum = 0, permission = {};

    Object.keys(groupPermissions).forEach((key) => {

        let check = 0;
        let notCheck = 0;

        groupPermissions[key].show = groupPermissions[key].show ?? false;

        if (groupPermissions[key].show) {
            onlyShowGroupSelected = true;
        }

        if (groupPermissions[key].children) {
            let checkedOfChildren = validateGroupPermissions(groupPermissions[key].children, user, withChangePermission, onlyShowGroupSelected);
            check = checkedOfChildren.check;
            notCheck = checkedOfChildren.notCheck;
            onlyShowGroupSelected = checkedOfChildren.onlyShowGroupSelected;
            permission = { ...permission, ...checkedOfChildren.permission };
        }

        if (groupPermissions[key].permission) {
            Object.keys(groupPermissions[key].permission).forEach(perKey => {

                let activePer;

                if (withChangePermission) {
                    activePer = groupPermissions[key].permission[perKey].checked;
                } else {
                    activePer = user.permission.hasOwnProperty(perKey) ? true : false;
                }

                groupPermissions[key].permission[perKey] = {
                    title: groupPermissions[key].permission[perKey].title ?? groupPermissions[key].permission[perKey],
                    checked: activePer,
                };

                if (activePer) {
                    permission[perKey] = true;
                }

                if (activePer) {
                    check++;
                } else {
                    notCheck++;
                }
            });
        }

        if (check === 0) {
            groupPermissions[key].checked = 0;
        } else if (notCheck === 0) {
            groupPermissions[key].checked = 2;
        } else {
            groupPermissions[key].checked = 1;
        }

        checkSum += check;
        notCheckSum += notCheck;

    });

    return {
        check: checkSum,
        notCheck: notCheckSum,
        permission,
        onlyShowGroupSelected
    };
}

function changeShowGroupPermissionMultiLevel(group, show) {
    group.show = show;
    if (group.children) {
        Object.keys(group.children).forEach(key => {
            changeShowGroupPermissionMultiLevel(group.children[key], show);
        });
    }
}

function GroupPermission({ user, setUser, group, handleChangeGroupPermission }) {

    const handleEditPermissionOfGroup = (group, checked) => {

        if (checked) {
            group.checked = 2;
        } else {
            group.checked = 0;
        }

        if (group.children) {
            Object.keys(group.children).forEach(key => {
                handleEditPermissionOfGroup(group.children[key], checked);
            });
        }

        if (group.permission) {
            Object.keys(group.permission).forEach(perKey => {
                group.permission[perKey].checked = checked;

                if (checked) {
                    user.permission[perKey] = true;
                } else {

                }

            });
        }
    }

    return (
        <ul style={{ margin: '0 0 0 24px ', padding: 0 }}>
            {Object.keys(group).map((key) => {
                return (
                    <li key={key} style={{ whiteSpace: 'nowrap', listStyle: 'none' }}>
                        <div className={'group-warper ' + (group[key].show ? 'active' : '')} >
                            <FormControlLabel
                                style={{ marginRight: 0 }}
                                control={<Checkbox
                                    indeterminate={group[key].checked === 1 ? true : false}
                                    color={group[key].checked === 1 ? 'default' : 'primary'}
                                    inputProps={{ 'aria-label': 'indeterminate checkbox' }}
                                    checked={group[key].checked !== 0 ? true : false}
                                    onClick={() => {
                                        let groupTemp = { ...group[key] };
                                        handleEditPermissionOfGroup(groupTemp, group[key].checked === 2 ? 0 : 2);
                                        handleChangeGroupPermission({
                                            ...group,
                                            [key]: groupTemp
                                        });

                                    }} />}
                                label={group[key].title}
                            />
                            <IconButton onClick={e => {
                                let groupTemp = { ...group[key] };
                                changeShowGroupPermissionMultiLevel(groupTemp, !group[key].show);
                                handleChangeGroupPermission({
                                    ...group,
                                    [key]: groupTemp
                                });
                            }} aria-label="view" className=" icon ">
                                <VisibilityRoundedIcon fontSize="small" className="icon" />
                            </IconButton>
                        </div>
                        {
                            group[key].children &&
                            <GroupPermission
                                user={user}
                                setUser={setUser}
                                group={group[key].children}
                                handleChangeGroupPermission={(groupEdit) => {
                                    handleChangeGroupPermission({
                                        ...group,
                                        [key]: {
                                            ...group[key],
                                            children: groupEdit
                                        }
                                    });
                                }}
                            />
                        }
                    </li>
                );
            })}
        </ul >
    );
}

function PermissionItems({ user, group, handleChangePermission, onlyShowGroupSelected }) {

    return (
        Object.keys(group).map(key => (
            <React.Fragment key={key}>
                {
                    group[key].children && <PermissionItems
                        user={user}
                        group={group[key].children}
                        handleChangePermission={handleChangePermission}
                        onlyShowGroupSelected={onlyShowGroupSelected} />
                }
                {
                    group[key].permission && (group[key].show || !onlyShowGroupSelected) &&
                    Object.keys(group[key].permission).map(perKey => (

                        !user.showGrantedType //All undefine || 0
                            || (user.showGrantedType === 1 && group[key].permission[perKey].checked) //Checked
                            || (user.showGrantedType === 2 && !group[key].permission[perKey].checked) //Not Checked
                            ?
                            <Grid key={perKey} style={{ paddingTop: 4, paddingBottom: 4 }} item md={4} xs={12}>
                                <FormControlLabel
                                    control={<Checkbox
                                        onClick={handleChangePermission(perKey)}
                                        name={perKey}
                                        checked={group[key].permission[perKey].checked ? true : false}
                                        color="primary"
                                    />}
                                    label={group[key].permission[perKey].title}
                                />
                            </Grid>
                            : <React.Fragment key={perKey}></React.Fragment>
                    ))
                }
            </React.Fragment>

        ))
    );
}


const useStyles = makeStyles((theme) => ({

    permission: {
        maxHeight: 500,
        overflowX: 'auto'
    },
    groupPermission: {
        borderRight: '1px solid',
        borderColor: theme.palette.divider + ' !important',
        maxHeight: 500,
        overflowX: 'auto',
        '& .group-warper': {
            display: 'flex', alignItems: 'center',
            '& .icon': {
                opacity: 0
            },
            '&.active .icon': {
                opacity: 1
            },
            '&:hover .icon': {
                opacity: 1
            },
        },
    },
    disable: {
        pointerEvents: 'none',
        opacity: '.5'
    },
    borderStyle: {
        borderColor: theme.palette.divider + ' !important',
    },
}))


export default Permission
