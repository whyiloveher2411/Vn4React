import { Checkbox, FormControlLabel } from '@material-ui/core';
import React from 'react'

function GroupPermission({ data, notFirstLevel, listGroupPermission, handleClickGroup, nameParent }) {
    return (
        <ul style={{ margin: notFirstLevel ? '0 0 0 24px ' : '0', padding: 0 }}>
            {Object.keys(data).map((key) => {
                return (
                    <li key={key} style={{ whiteSpace: 'nowrap', listStyle: 'none' }}>
                        <FormControlLabel
                            control={<Checkbox
                                indeterminate={listGroupPermission[key].checked === 1 ? true : false}
                                color={listGroupPermission[key].checked === 1 ? 'default' : 'primary'}
                                inputProps={{ 'aria-label': 'indeterminate checkbox' }}
                                checked={listGroupPermission[key].checked !== 0 ? true : false}
                                onClick={e => handleClickGroup(e, [...nameParent, key])} />}
                            label={data[key].title}
                        />
                        {
                            data[key].children && <GroupPermission listGroupPermission={listGroupPermission[key].children} handleClickGroup={handleClickGroup} nameParent={[...nameParent, key]} notFirstLevel data={data[key].children} />
                        }
                    </li>
                );
            })}
        </ul >
    );
}

export default GroupPermission
