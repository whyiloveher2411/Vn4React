import { Avatar, Box, List, ListItem, makeStyles, Popover, Typography } from '@material-ui/core';
import Divider from '@material-ui/core/Divider';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import ArrowRightIcon from '@material-ui/icons/ArrowRight';
import DraftsIcon from '@material-ui/icons/Drafts';
import InboxIcon from '@material-ui/icons/Inbox';
import React from 'react';
import { isMouseScroll } from 'utils/useMouseScroll';
import FileItem from './FileItem';
import { FileDragDrop } from 'components';

const useStyles = makeStyles((theme) => ({
    root: {
        border: '1px solid transparent',
        minHeight: '100%',
    },
    selected: {
        backgroundColor: theme.palette.divider
    },
    file: {
        padding: '12px 16px',
        position: 'relative',
        cursor: 'pointer',
        '&:hover': {
            backgroundColor: 'rgba(0, 0, 0, 0.04)',
        }
    },
    menuFile: {
        userSelect: 'none',
        maxHeight: 500,
        maxWidth: 448,
        minWidth: 320,
    }
}));

export default React.memo(function DirColumn({ resource, setOpenRenameDialog, handleOnLoadDir, propsFileDragDrop, onClickDir, indexDir, onClickImage = () => { }, onClickFile = () => { } }) {

    const [selected, setSelected] = React.useState(false);

    const classes = useStyles();

    React.useEffect(() => {
        setSelected(false);
    }, [resource]);

    const handelOnClick = (item) => {
        if (selected !== item.basename && !isMouseScroll()) {
            if (item.is_dir) {
                onClickDir(item, indexDir);
                setSelected(item.basename);
            } else if (item.is_image) {
                onClickImage(item, indexDir);
            } else {
                onClickFile(item, indexDir)
            }

        }
    }

    const onFileDragDrop = FileDragDrop({
        path: resource.path,
        ...propsFileDragDrop,
    });

    const handleReloadDir = (reloadChildrenDir = true) => {
        handleOnLoadDir(resource.path, indexDir, false, resource.version + 1, reloadChildrenDir);
    };


    if (resource) {
        return (
            <div
                className={classes.root}
                {...onFileDragDrop}
            >
                {
                    resource.files.map((item, i) => (
                        <FileItem
                            key={i}
                            className={classes.file + ' ' + (selected === item.basename ? classes.selected : '')}
                            onClick={(e) => { handelOnClick(item) }}
                            file={item}
                            handleReloadDir={handleReloadDir}
                            setOpenRenameDialog={setOpenRenameDialog}
                        />
                    ))
                }
            </div>
        )
    }

    return <></>;

}, (props1, props2) => {
    // return props1.resource.path === props2.resource.path;
    return props1.resource.path === props2.resource.path && props1.resource.version === props2.resource.version;
})
