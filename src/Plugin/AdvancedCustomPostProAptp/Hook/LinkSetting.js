import React from 'react'
import NavigateNextIcon from '@material-ui/icons/NavigateNext';
import { Link } from 'react-router-dom';

function LinkSetting() {
    return (
        <>
            <NavigateNextIcon fontSize="small" /> <Link to="/post-type/page/list" >Custom Fields</Link>
        </>
    )
}

export default LinkSetting
