import { Card, CardContent, Checkbox, FormControl, FormControlLabel, Grid, InputLabel, MenuItem, Select, Typography } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import { makeStyles } from '@material-ui/styles';
import { Button } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import GroupPermission from './GroupPermission';
import PermissionList from './PermissionList';

const useStyles = makeStyles((theme) => ({
    root: {},
    header: {
        padding: '0 24px 24px',
        margin: '0px -24px 16px -24px',
        borderBottom: '1px solid ' + theme.palette.divider,
    },
    content: {
        width: 'calc(100% + 48px)',
        margin: '-16px -32px -24px -24px'
    },
    permission: {
        maxHeight: 500,
        overflowX: 'auto'
    },
    groupPermission: {
        borderRight: '1px solid #dedede',
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

export default function Permission({ user, handleSubmit, shareData, setShareData }) {

    const classes = useStyles();

    const { ajax } = useAjax();


    const [hasShowGroup, setHasShowGroup] = React.useState(false);

    const [permissions, setPermissions] = React.useState(shareData.permission?.permission);
    const [listGroupPermission, setListGroupPermission] = React.useState(shareData.permission?.listGroupPermission);
    const [render, setRender] = React.useState(0);

    const [setting, setSetting] = React.useState(
        shareData.permission?.setting ??
        {
            grantedOnly: false,
            role: user.role
        }
    );



    const getPermissionList = (data) => {

        let listP = {};

        Object.keys(data).forEach(key => {

            if (!listP[key]) listP[key] = {};

            listP[key].checked = 0;

            if (data[key].children) {
                listP[key].children = getPermissionList(data[key].children);
            }

            if (data[key].permission) {

                if (!listP[key].permission) listP[key].permission = {};

                Object.keys(data[key].permission).forEach(per => {
                    listP[key].permission[per] = false;
                });
            }

        });

        return listP;

    };

    const changeCheckedPermission = (arg, checked) => {

        Object.keys(arg).forEach(group => {

            if (arg[group].permission) {
                Object.keys(arg[group].permission).forEach(per => {
                    arg[group].permission[per] = checked;
                });
            }

            if (arg[group].children) {
                changeCheckedPermission(arg[group].children, checked);
            }

            if (checked) {
                arg[group].checked = 2;
            } else {
                arg[group].checked = 0;
            }

        });
    };


    const checkCheckedGroup = (group) => {

        let checkedPermission = false;
        let checkedGroup = false;

        if (group.permission) {

            let values = Object.values(group.permission);
            let checkeds = values.filter(check => check);

            if (checkeds.length === 0) {
                checkedPermission = 0;
            } else if (checkeds.length === values.length) {
                checkedPermission = 2;
            } else {
                checkedPermission = 1;
            }
        }

        if (group.children && Object.keys(group.children).length) {
            let arrayTemp = [];
            Object.keys(group.children).forEach(g => {
                let result = checkCheckedGroup(group.children[g]);
                if (arrayTemp.indexOf(result) === -1) {
                    arrayTemp.push(result);
                }
            });

            if (arrayTemp.length > 1) {
                checkedGroup = 1;
            } else {
                checkedGroup = arrayTemp[0];
            }
        }


        if (checkedPermission !== false && checkedGroup !== false) {
            if (checkedPermission === checkedGroup) {
                group.checked = checkedGroup;
                return checkedGroup;
            } else {
                group.checked = 1;
                return 1;
            }
        }

        if (checkedPermission !== false) {
            group.checked = checkedPermission;
            return checkedPermission;
        }

        return checkedGroup;
    };


    const reviewPermission = (l = listGroupPermission) => {
        Object.keys(l).forEach(group => {
            l[group].checked = checkCheckedGroup(l[group]);
        });
        setRender(render + 1);
    };

    const changeShowGroup = (group, show) => {
        group.show = show;

        if (group.children) {
            Object.keys(group.children).forEach(key => {
                changeShowGroup(group.children[key], show);
            });
        }
    }

    const checkHasShowGroup = (g = permissions) => {

        if (g.show) {
            return true;
        }

        if (g.children) {

            let g2 = Object.keys(g.children);

            for (let index = 0; index < g2.length; index++) {

                if (checkHasShowGroup(g.children[g2[index]])) {
                    return true;
                }

            }
        }

        return false;
    };

    const handleShowGroup = (group) => {
        group.show = !group.show;

        if (group.children) {
            Object.keys(group.children).forEach(key => {
                changeShowGroup(group.children[key], group.show);
            });
        }

        let hasShowGroup = false;

        let g = Object.keys(permissions);

        for (let index = 0; index < g.length; index++) {
            if (checkHasShowGroup(permissions[g[index]])) {
                hasShowGroup = true;
                break;
            }

        }
        setHasShowGroup(hasShowGroup);
        setRender(render + 1);
    };

    let handleClickGroup = (e, group) => {

        let check = e.target.checked;
        let temp = [listGroupPermission];
        let temp2 = listGroupPermission;
        let length = group.length;

        group.forEach((groupName, index) => {
            if (index === 0) {
                temp2 = temp2[groupName];
            } else {
                temp2 = temp2.children[groupName];
            }
            temp[index] = temp2;
        });



        if (check) {
            temp2.checked = 2;
        } else {
            temp2.checked = 0;
        }

        if (temp2.permission) {
            Object.keys(temp2.permission).forEach(per => {
                temp2.permission[per] = check;
            });
        }

        if (temp2.children) {
            changeCheckedPermission(temp2.children, check);
        }

        for (let i = length - 2; i > -1; i--) {

            let checkGroup = 0;
            let allCheck = true;

            Object.keys(temp[i].children).forEach(g => {
                if (temp[i].children[g].checked === 2) {
                    if (checkGroup !== 2) {
                        checkGroup = 1;
                    }
                } else if (temp[i].children[g].checked === 1) {
                    checkGroup = 1;
                    allCheck = false;
                } else {
                    allCheck = false;
                }
            });

            if (allCheck) {
                temp[i].checked = 2;
            } else {
                temp[i].checked = checkGroup;
            }

        }
        setRender(render + 1);

    }

    React.useEffect(() => {

        if (!permissions) {
            ajax({
                url: 'profile/permission',
                method: 'POST',
                success: function (result) {
                    if (result.permissions) {

                        console.log(result);

                        let groupPermission = getPermissionList(result.permissions);

                        if (user.permission) {

                            if (typeof user.permission !== 'object') {
                                user.permission = user.permission.split(', ');
                            }

                            const changeGroupInital = group => {
                                if (group.permission) {

                                    Object.keys(group.permission).forEach(per => {
                                        if (user.permission.indexOf(per) !== -1) {
                                            group.permission[per] = true;
                                        }
                                    });

                                }

                                if (group.children) {
                                    Object.keys(group.children).forEach(g => {
                                        changeGroupInital(group.children[g]);
                                    });
                                }

                            };

                            Object.keys(groupPermission).forEach(group => {
                                changeGroupInital(groupPermission[group]);
                            });

                            reviewPermission(groupPermission);

                        }

                        console.log(groupPermission);
                        setPermissions(result.permissions);
                        setListGroupPermission(groupPermission);
                    }
                }
            });
        }
    }, []);

    const getListPermission = group => {

        let temp = {};

        if (group.permission) {
            Object.keys(group.permission).forEach(per => {
                if (group.permission[per]) {
                    temp[per] = true;
                }
            });
        }

        if (group.children) {

            Object.keys(group.children).forEach(g => {
                temp = { ...temp, ...getListPermission(group.children[g]) };
            });
        }

        return temp;

    };

    React.useEffect(() => {
        console.log(listGroupPermission);
        if (listGroupPermission) {
            let temp = {};

            Object.keys(listGroupPermission).forEach(group => {
                temp = { ...temp, ...getListPermission(listGroupPermission[group]) };
            });

            user.permission = Object.keys(temp);
        }

    }, [render]);

    return (
        <Card>

            <CardContent>
                <Typography variant='h5' className={classes.header} >
                    <FormControl size="small" variant="outlined">
                        <InputLabel id="role">Role</InputLabel>
                        <Select
                            size="small"
                            labelId="role"
                            value={!setting.role || setting.role === '' ? 'custom' : setting.role}
                            label="Role"
                            onChange={e => {
                                // setShareData({
                                //     ...shareData,
                                //     permission: {
                                //         listGroupPermission: listGroupPermission, permission: permissions,
                                //         setting: { ...setting, role: e.target.value }
                                //     }
                                // });
                                user.role = e.target.value === 'custom' ? '' : e.target.value; setSetting({ ...setting, role: e.target.value });
                            }}
                        >
                            <MenuItem value="custom">
                                <em>--Custom--</em>
                            </MenuItem>
                            <MenuItem value={'Super Admin'}>Super Admin</MenuItem>
                        </Select>
                    </FormControl>
                    &nbsp;
                    <Button
                        type="submit"
                        onClick={handleSubmit}
                        color="success"
                        variant="contained">
                        Save Changes
                    </Button>
                </Typography>


                {
                    permissions && listGroupPermission ?
                        <Grid container spacing={4} className={classes.content + ' ' + (!setting.role || setting.role === 'custom' || setting.role === '' ? '' : classes.disable)}>
                            <Grid className={classes.borderStyle} style={{ borderRight: '1px solid #dedede', borderBottom: '1px solid #dedede' }} item md={4} xs={12}>
                                <p>Group (Granted/Total)</p>
                            </Grid>
                            <Grid className={classes.borderStyle} style={{ borderBottom: '1px solid #dedede', display: 'flex' }} item md={8} xs={12}>
                                <FormControlLabel
                                    control={<Checkbox checked={setting.grantedOnly} onClick={e => {
                                        setSetting({ ...setting, grantedOnly: e.target.checked })
                                    }} />}
                                    label='Granted Only'
                                />
                            </Grid>
                            <Grid className={classes.groupPermission + ' custom_scroll'} item md={4} xs={12}>
                                <GroupPermission handleShowGroup={handleShowGroup} data={permissions} listGroupPermission={listGroupPermission} nameParent={[]} handleClickGroup={handleClickGroup} />
                            </Grid>
                            <Grid item md={8} xs={12} className={classes.permission + ' custom_scroll'}>
                                <Grid container spacing={4} style={{ paddingTop: 12 }}>
                                    <PermissionList hasShowGroup={hasShowGroup} reviewPermission={reviewPermission} setting={setting} data={permissions} mePermission={''} listGroupPermission={listGroupPermission} />
                                </Grid>
                            </Grid>
                        </Grid>
                        :
                        <Grid container className={classes.content} spacing={4}>
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
                }
            </CardContent>
        </Card>
    )
}