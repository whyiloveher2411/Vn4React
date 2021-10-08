import { Checkbox, FormControlLabel, Grid } from '@material-ui/core';
import React from 'react'

function PermissionList({ data, mePermission, reviewPermission, setting, listGroupPermission, hasShowGroup }) {

    const handleCheckPermission = (e, group, per) => {
        listGroupPermission[group].permission[per] = e.target.checked;
        reviewPermission();
    };

    return (
        Object.keys(data).map(key => (
            <React.Fragment key={key}>
                {
                    data[key].children && <PermissionList hasShowGroup={hasShowGroup} reviewPermission={reviewPermission} setting={setting} listGroupPermission={listGroupPermission[key].children} data={data[key].children} mePermission={mePermission} />
                }
                {
                    data[key].permission &&
                    Object.keys(data[key].permission).map(key2 => (

                        data[key].show || !hasShowGroup ?
                            (
                                !setting.grantedOnly || listGroupPermission[key].permission[key2] ?
                                    <Grid key={key2} style={{ paddingTop: 4, paddingBottom: 4 }} item md={4} xs={12}>
                                        <FormControlLabel
                                            control={<Checkbox onClick={e => handleCheckPermission(e, key, key2)} name={key2} checked={listGroupPermission[key].permission[key2] ? true : false} color="primary" name={key2} />}
                                            label={data[key].permission[key2]}
                                        />
                                    </Grid>
                                    : <React.Fragment key={key2}></React.Fragment>
                            ) : null
                    ))
                }
            </React.Fragment>

        ))
    );
}

export default PermissionList
