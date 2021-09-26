import { Box } from '@material-ui/core';
import Checkbox from '@material-ui/core/Checkbox';
import Chip from '@material-ui/core/Chip';
import TextField from '@material-ui/core/TextField';
import CheckBoxIcon from '@material-ui/icons/CheckBox';
import CheckBoxOutlineBlankIcon from '@material-ui/icons/CheckBoxOutlineBlank';
import Autocomplete from '@material-ui/lab/Autocomplete';
import React from 'react';
import { convertListToTree } from 'utils/helper';
import { useAjax } from 'utils/useAjax';

const icon = <CheckBoxOutlineBlankIcon fontSize="small" />;
const checkedIcon = <CheckBoxIcon fontSize="small" />;

export default function RelationshipManyToManyFormForm(props) {

    let { config, post, onReview, name, ...rest } = props;
    const { ajax } = useAjax();

    const [open, setOpen] = React.useState(false);
    const [options, setOptions] = React.useState(false);

    const [loading, setLoading] = React.useState(false);
    const [render, setRender] = React.useState(0);

    let valueInital = [];

    try {
        if (post[name] && typeof post[name] === 'object') {
            valueInital = post[name];
        } else {
            if (post[name]) {
                valueInital = JSON.parse(post[name]);
            }
        }

        if (!Array.isArray(valueInital)) valueInital = [];
    } catch (error) {
        valueInital = [];
    }

    post[name] = valueInital;


    const convertTitleToStructParent = (posts, spacing, spacingstandard, titleParents) => {

        let result = [];


        posts.forEach(post => {

            post.optionLabel = spacing;
            post.titleParents = titleParents;

            result.push({ ...post });

            if (post.children) {
                result = [...result, ...convertTitleToStructParent(post.children, spacing + spacingstandard, spacingstandard, [...titleParents, post.title])];
            }

        });

        return result;
    }

    React.useEffect(() => {

        if (options === false) {

            if (!loading) {
                return undefined;
            }

            ajax({
                url: 'post-type/relationship/' + config.object,
                method: 'POST',
                data: config,
                isGetData: false,
                success: function (result) {
                    if (result.rows) {

                        if (config.hierarchical) {

                            let tree = convertListToTree(result.rows);
                            let posts = convertTitleToStructParent(tree, '', (config.separator ?? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'), []);
                            setOptions(posts);

                        } else {
                            setOptions(result.rows);
                        }

                    } else {
                        setOptions(false);
                    }
                    setLoading(false);
                }
            });
        }

    }, [loading]);

    const handleOnChange = (e, value) => {
        post[name] = value;
        onReview(value);
        setRender(render + 1);
    };

    const handleKeyPress = (e) => {

        if (e.key === 'Enter') {

            setOptions([]);

            ajax({
                url: 'post-type/relationship/' + config.object,
                method: 'POST',
                isGetData: false,
                data: {
                    ...config,
                    key: e.target.value
                },
                success: function (result) {
                    if (result.rows) {
                        setOptions(result.rows);
                    }
                }
            });
        }
    }

    console.log('render RELATIONSHIP MANY TO MANY');

    return (
        <Autocomplete
            multiple
            open={open}
            onOpen={() => { setOpen(true); setLoading(true); }}
            onClose={() => {
                setOpen(false);
            }}
            value={valueInital}
            options={options !== false ? options : []}
            disableCloseOnSelect
            getOptionSelected={(option, value) => option.id === value.id}
            getOptionLabel={(option) => option.title}
            loading={loading}
            onChange={handleOnChange}
            renderTags={(tagValue, getTagProps) =>
                tagValue.map((option, index) => (
                    <Chip
                        label={
                            (option.titleParents?.length > 0 ? (option.titleParents.join(' -> ') + ' -> ') : '') + option.title
                        }
                        {...getTagProps({ index })}
                    />
                ))
            }
            renderOption={(option, { selected }) => (
                <Box display="flex" alignItems="center" width={1}>
                    <span dangerouslySetInnerHTML={{ __html: option.optionLabel }} />
                    <Checkbox
                        icon={icon}
                        checkedIcon={checkedIcon}
                        style={{ marginRight: 8 }}
                        checked={selected}
                        color="primary"
                    />
                    {option.title}
                    {Boolean(option.new_post) && <strong>&nbsp;(New Option)</strong>}
                </Box>
            )}
            renderInput={(params) => {
                return <TextField {...params} onKeyPress={handleKeyPress} variant="outlined" label={config.title} placeholder={config.placeholder ?? 'Add'} />
            }}
            {...rest}
        />
    );
}