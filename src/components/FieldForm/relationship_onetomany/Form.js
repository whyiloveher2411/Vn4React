import React from 'react';
import TextField from '@material-ui/core/TextField';
import Autocomplete from '@material-ui/lab/Autocomplete';
import CircularProgress from '@material-ui/core/CircularProgress';
import { useAjax } from 'utils/useAjax';
import { convertListToTree } from 'utils/helper';

export default function RelationshipOneToManyForm(props) {
  let { config, post, onReview, name, ...rest } = props;

  const { ajax } = useAjax();

  const [open, setOpen] = React.useState(false);
  const [options, setOptions] = React.useState(false);
  const loading = open && options === false;

  const [render, setRender] = React.useState(0);

  let valueInital = config.valueDefault ? config.valueDefault : { id: 0, title: '' };

  try {
    if (typeof post[name + '_detail'] === 'object') {
      valueInital = post[name + '_detail'];
    } else {
      if (post[name] && post[name + '_detail']) {
        valueInital = JSON.parse(post[name + '_detail']);
      }
    }
  } catch (error) {
    valueInital = { id: 0, title: '' };
  }

  post[name] = valueInital?.id;

  const convertTitleToStructParent = (posts, spacing, spacingstandard) => {

    let result = [];


    posts.forEach(post => {

      post.optionLabel = spacing;

      result.push({ ...post });

      if (post.children) {
        result = [...result, ...convertTitleToStructParent(post.children, spacing + spacingstandard, spacingstandard)];
      }

    });

    return result;
  }

  React.useEffect(() => {

    if (options === false) {
      let active = true;

      if (!loading) {
        return undefined;
      }

      (async () => {
        ajax({
          url: 'post-type/relationship/' + config.object,
          success: function (result) {
            if (result.rows && active) {
              if (config.hierarchical) {
                let tree = convertListToTree(result.rows);
                let posts = convertTitleToStructParent(tree, '', (config.separator ?? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'));
                setOptions(posts);
              } else {
                setOptions(result.rows);
              }
            }
          }
        });
      })();

      return () => {
        active = false;
      };

    }

  }, [loading]);

  const handleOnChange = (e, value) => {
    if (value) {

      post[name] = value.id;
      post[name + '_detail'] = value;

      onReview(null, {
        [name]: value.id,
        [name + '_detail']: value
      });

    } else {

      post[name] = null;
      post[name + '_detail'] = null;

      onReview(null, {
        [name]: null,
        [name + '_detail']: null
      });
    }

    setRender(render + 1);
  };


  const handleKeyPress = (e) => {

    if (e.key === 'Enter') {
      // setOptions(false);
      ajax({
        url: 'post-type/relationship/' + config.object,
        method: 'POST',
        data: {
          key: e.target.value
        },
        success: function (result) {
          setOptions(result.rows);
        }
      });
    }
  }


  console.log('render RELATIONSHIP ONE TO MANY');

  return (
    <Autocomplete
      open={open}
      onOpen={() => {
        setOpen(true);
      }}
      onClose={() => {
        setOpen(false);
      }}
      value={valueInital || { id: 0, title: '' }}
      defaultValue={valueInital || { id: 0, title: '' }}
      getOptionSelected={(option, value) => option.id === value.id}
      getOptionLabel={(option) => option.title + (option.new_post ? ' (New Option)' : '')}
      onChange={handleOnChange}
      options={options !== false ? options : []}
      loading={loading}
      renderOption={(option, { selected }) => (
        <><span dangerouslySetInnerHTML={{ __html: option.optionLabel }} />{option.title} {Boolean(option.new_post) && '(New Option)'}</>
      )}
      renderInput={(params) => (
        <TextField
          {...params}
          label={config.title}
          variant="outlined"
          onKeyPress={handleKeyPress}
          InputProps={{
            ...params.InputProps,
            endAdornment: (
              <React.Fragment>
                {loading ? <CircularProgress color="inherit" size={20} /> : null}
                {params.InputProps.endAdornment}
              </React.Fragment>
            ),
          }}
        />
      )}
      {...config.inputProps}
      {...rest}
    />
  );
}