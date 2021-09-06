import { Avatar, Box, makeStyles, SvgIcon, Typography } from '@material-ui/core';
import React from 'react';
import { isMouseScroll } from 'utils/useMouseScroll';

const useStyles = makeStyles((theme) => ({
    selected: {
        backgroundColor: theme.palette.divider
    },
    file: {
        margin: '4px 0', padding: '8px 16px',
        cursor: 'pointer',
        '&:hover': {
            backgroundColor: 'rgba(0, 0, 0, 0.04)',
        }
    },
    avatar: {
        backgroundImage: 'url(/admin/fileExtension/trans.jpg)',
        backgroundSize: '13px'
    }
}));



function DirColumnSelected({ files, onClickDir, indexDir, onClickImage = () => { }, onClickFile = () => { } }) {

    const [selected, setSelected] = React.useState(false);

    const classes = useStyles();
    
    if (files) {
        return (
            <div
                component="nav"
            >
                {
                    files.map((item, index) => (
                        <Box
                            display="flex"
                            gridGap={8}
                            width={1}
                            alignItems="center"
                            key={index}
                            className={classes.file + ' ' + (selected === index ? classes.selected : '')}
                            onClick={(e) => {
                                if (!isMouseScroll()) {
                                    if (item.is_dir) {
                                        onClickDir(item, indexDir);
                                        setSelected(index);
                                    } else if (item.is_image) {
                                        onClickImage(item, indexDir);
                                    } else {
                                        onClickFile(item, indexDir)
                                    }
                                }
                            }}
                        >
                            {
                                item.is_dir ?
                                    <SvgIcon style={{ width: 40, height: 40 }}>
                                        <svg x="0px" y="0px" height="40px" width="40px" focusable="false" viewBox="0 0 40 40" fill="#69caf7"><g><path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"></path><path d="M0 0h24v24H0z" fill="none"></path></g></svg>
                                    </SvgIcon>
                                    :
                                    <Avatar
                                        className={classes.avatar}
                                        variant="square"
                                        src={item.thumbnail}
                                    />

                            }

                            <div style={{ flexGrow: 1, overflow: 'hidden', whiteSpace: 'nowrap', textOverflow: 'ellipsis' }}>
                                <Typography noWrap variant="body1">
                                    {item.basename}
                                </Typography>
                                {
                                    !item.is_dir &&
                                    <Typography variant="body2">
                                        {item.filesize}
                                    </Typography>
                                }
                            </div>
                        </Box>
                    ))
                }
            </div>
        )
    }

    return <></>;
}

export default DirColumnSelected
