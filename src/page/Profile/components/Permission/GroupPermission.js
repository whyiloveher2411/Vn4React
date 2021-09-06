import { Checkbox, FormControlLabel, IconButton } from '@material-ui/core';
import React from 'react'
import VisibilityRoundedIcon from '@material-ui/icons/VisibilityRounded';
function GroupPermission({ data, notFirstLevel, listGroupPermission, handleClickGroup, nameParent, handleShowGroup }) {

    const changeShowGroup = (key) => {
        handleShowGroup(data[key]);
    }

    return (
        <ul style={{ margin: notFirstLevel ? '0 0 0 24px ' : '0', padding: 0 }}>
            {Object.keys(data).map((key) => {
                return (
                    <li key={key} style={{ whiteSpace: 'nowrap', listStyle: 'none' }}>
                        <div className={'group-warper ' + (data[key].show ? 'active' : '')} >
                            <FormControlLabel
                                style={{ marginRight: 0 }}
                                control={<Checkbox
                                    indeterminate={listGroupPermission[key].checked === 1 ? true : false}
                                    color={listGroupPermission[key].checked === 1 ? 'default' : 'primary'}
                                    inputProps={{ 'aria-label': 'indeterminate checkbox' }}
                                    checked={listGroupPermission[key].checked !== 0 ? true : false}
                                    onClick={e => handleClickGroup(e, [...nameParent, key])} />}
                                label={data[key].title}
                            />
                            <IconButton onClick={e => changeShowGroup(key)} aria-label="view" className=" icon ">
                                <VisibilityRoundedIcon fontSize="small" className="icon" />
                            </IconButton>
                        </div>
                        {
                            data[key].children && <GroupPermission handleShowGroup={handleShowGroup} listGroupPermission={listGroupPermission[key].children} handleClickGroup={handleClickGroup} nameParent={[...nameParent, key]} notFirstLevel data={data[key].children} />
                        }
                    </li>
                );
            })}
        </ul >
    );
}

export default GroupPermission
