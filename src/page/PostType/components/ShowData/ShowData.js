import { Box, Grid, Table, TableBody, TableCell, TableRow } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import { AddOn, Button, Divider, Hook, Page, TabsCustom } from 'components';
import React, { useEffect, useState } from 'react';
import { Link, Redirect } from 'react-router-dom';
import { toCamelCase } from 'utils/helper';
import { getUrlParams, replaceUrlParam } from 'utils/herlperUrl';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import { usePermission } from 'utils/user';
import FilterTab from './FilterTab';
import Header from './Header';
import Results from './Results';
import SearchBar from './SearchBar';

const ShowData = (props) => {

    const { match, history } = props;

    const [data, setData] = useState([]);
    const [title, setTitle] = useState('...');

    const [showLoading, setShowLoading] = useState(true);
    const [isLoadedData, setIsLoadedData] = useState(false);
    const [render, setRender] = useState(0);

    const permission = usePermission(match.params.type + '_create');

    const { callAddOn } = AddOn();

    const { ajax, Loading } = useAjax({ loadingType: 'custom' });

    const valueInital = {
        rowsPerPage: 10,
        page: 1,
        search: '',
        filter: 'all',
        ...getUrlParams(window.location.search)
    };

    const [queryUrl, setQueryUrl] = useState(valueInital);

    useEffect(() => {
        setQueryUrl({ ...valueInital, ...getUrlParams(window.location.search) });
    }, [match]);

    const ajaxHandle = (params) => {

        setShowLoading(true);

        ajax({
            url: `post-type/${params.url}`,
            method: 'POST',
            data: params.data,
            success: (result) => {

                if (params.success) {
                    params.success(result);
                }

            },
            finally: () => {
                setShowLoading(false);

                if (params.finally) {
                    params.finally();
                }
            }
        });

    };

    useEffect(() => {

        if (!render) {
            setRender(render + 1);
            return;
        }

        let mounted = true

        ajaxHandle({
            url: `get-data/${match.params.type}`,
            method: 'POST',
            data: queryUrl,
            success: function (result) {

                if (result.redirect) {
                    history.push(result.redirect);
                } else {

                    if (result.config && mounted) {
                        result.type = match.params.type;

                        result.config.extendedTab = callAddOn('ShowData/Tabs', match.params.type, { list: { title: __('List'), priority: 1 } });

                        setData(result);
                        setTitle(result.config?.title);
                        setIsLoadedData(true);
                        let url = replaceUrlParam(window.location.href, queryUrl);
                        window.history.pushState({ url: url, page: 'Page template table' }, "Page template table", url);

                    }
                }
            }
        });

        return () => {
            mounted = false
        }

    }, [queryUrl]);

    const acctionPost = (payload, success) => {
        ajaxHandle({
            url: `get-data/${match.params.type}`,
            method: 'POST',
            data: {
                ...queryUrl,
                ...payload,
            },
            success: function (result) {
                if (result.config) {
                    result.config.extendedTab = callAddOn('ShowData/Tabs', match.params.type, { list: { title: __('List'), priority: 1 } });
                    setData(prev => ({ ...prev, ...result }));
                }
                if (success) {
                    success(result);
                }
            }
        });
    };

    const handleFilter = () => { }
    const handleSearch = (value) => {
        setQueryUrl({
            ...queryUrl,
            search: value
        });
    }

    const ListDataComponent = (
        <Box display="flex">
            <div style={{ width: 255, flexShrink: 0, paddingRight: 24 }}>
                <Button component={Link} to={`/post-type/${match.params.type}/new`} variant="contained" size="large" disabled={!permission[match.params.type + '_create']} color="primary" style={{ width: '100%', marginBottom: 24 }}>
                    {__('Add new')}
                </Button>
                <FilterTab
                    name={match.params.type}
                    acctionPost={acctionPost}
                    queryUrl={queryUrl}
                    data={data}
                    onFilter={handleFilter}
                    setQueryUrl={setQueryUrl}
                    options={data.config ?? {}}
                />
            </div>
            <div style={{ width: 'calc(100% - 255px) ' }}>
                <SearchBar onValue={queryUrl.search} onSearch={handleSearch} />
                {data && (
                    <Results
                        result={data}
                        loading={showLoading}
                        queryUrl={queryUrl}
                        setQueryUrl={setQueryUrl}
                        isLoadedData={isLoadedData}
                        history={props.history}
                        postType={match.params.type}
                        acctionPost={acctionPost}
                        onFilter={handleFilter}
                    />
                )}
            </div>
        </Box>
    );

    const redirectTo = getUrlParams(window.location.search, 'redirectTo');

    if (data.config?.redirect) {
        return <Redirect to={data.config?.redirect} />
    }

    if (redirectTo === 'edit') {
        return <Redirect to={`/post-type/${match.params.type}/edit?post_id=` + getUrlParams(window.location.search, 'post')} />
    }

    return (
        <>
            <Hook
                hook={'PostType/' + toCamelCase(match.params.type) + '/ShowData'}
                result={data}
                loading={showLoading}
                queryUrl={queryUrl}
                setQueryUrl={setQueryUrl}
                isLoadedData={isLoadedData}
                history={props.history}
                postType={match.params.type}
                acctionPost={acctionPost}
                onFilter={handleFilter} />
            {
                Boolean(data && data.config && data.config.extendedTab && Object.keys(data.config.extendedTab).length > 0)
                    ?
                    <Page title={title} width="xl">
                        <Header type={match.params.type} config={data.config} />
                        <TabsCustom
                            name={'show_data_' + match.params.type}
                            tabs={
                                (() => {
                                    let result = Object.keys(data.config.extendedTab).map(key => {

                                        if (key === 'list') {
                                            return {
                                                ...data.config.extendedTab[key],
                                                title: data.config.extendedTab[key].title ?? __('List'),
                                                content: () => ListDataComponent
                                            }
                                        }

                                        if (data.config.extendedTab[key].content) {
                                            return {
                                                ...data.config.extendedTab[key],
                                                content: () => <Hook
                                                    hook={data.config.extendedTab[key].content} {...props}
                                                    result={data}
                                                    loading={showLoading}
                                                    queryUrl={queryUrl}
                                                    setQueryUrl={setQueryUrl}
                                                    isLoadedData={isLoadedData}
                                                    history={props.history}
                                                    postType={match.params.type}
                                                    acctionPost={acctionPost}
                                                    onFilter={handleFilter}
                                                />
                                            }
                                        }

                                        if (data.config.extendedTab[key].component) {
                                            return {
                                                ...data.config.extendedTab[key],
                                                content: () => data.config.extendedTab[key].component({
                                                    result: data,
                                                    loading: showLoading,
                                                    queryUrl: queryUrl,
                                                    setQueryUrl: setQueryUrl,
                                                    isLoadedData: isLoadedData,
                                                    history: props.history,
                                                    postType: match.params.type,
                                                    acctionPost: acctionPost,
                                                    onFilter: handleFilter
                                                })
                                            }
                                        }
                                    });
                                    return result;
                                })()
                            }
                        />
                    </Page>
                    :
                    <SkeletonListData />
            }
        </>
    )
}

function SkeletonListData() {

    return (
        <Page title={'Post Type'} width="xl">
            <Grid
                alignItems="flex-end"
                container
                justify="space-between"
                spacing={3}
                style={{ marginBottom: 8 }}
            >
                <Grid item>
                    <Skeleton width={100} height={13} style={{ transform: 'scale(1, 1)', marginBottom: 8 }} />
                    <Skeleton width={200} height={28} style={{ transform: 'scale(1, 1)', marginBottom: 8 }} />
                </Grid>
            </Grid>

            <Box display="flex" width={1} gridGap={32} style={{ marginBottom: 10 }}>
                <Skeleton style={{ transform: 'scale(1, 1)' }} width={80} height={22} />
                <Skeleton style={{ transform: 'scale(1, 1)' }} width={80} height={22} />
                <Skeleton style={{ transform: 'scale(1, 1)' }} width={80} height={22} />
            </Box>
            <Divider />
            <Box display="flex" gridGap={24} width={1} style={{ marginTop: 16 }}>
                <div>
                    <Skeleton style={{ transform: 'scale(1, 1)', marginBottom: 24 }} width={230} height={40} />
                    {
                        [...Array(10)].map((key, index) => (
                            <Skeleton key={index} style={{ transform: 'scale(1, 1)', marginBottom: 12 }} width={230} height={24} />
                        ))
                    }
                </div>
                <div style={{ width: '100%' }}>
                    <Box display="flex" gridGap={12} width={1}>
                        <Skeleton style={{ transform: 'scale(1, 1)', marginBottom: 24 }} width={230} height={40} />
                        <Skeleton style={{ transform: 'scale(1, 1)', marginBottom: 24 }} width={120} height={40} />
                    </Box>
                    <div>
                        <Skeleton variant='text' style={{ transform: 'scale(1, 1)', marginBottom: 8 }} width={280} height={18} />
                        <Table style={{ width: '100%' }}>
                            <TableBody>
                                {
                                    [...Array(8)].map((key, index) => (
                                        <TableRow key={index}>
                                            <TableCell>
                                                <Skeleton style={{ transform: 'scale(1, 1)' }} width={48} height={32} />
                                            </TableCell>
                                            <TableCell>
                                                <Skeleton style={{ transform: 'scale(1, 1)' }} width={48} height={32} />
                                            </TableCell>
                                            <TableCell>
                                                <Skeleton style={{ transform: 'scale(1, 1)' }} width={200} height={32} />
                                            </TableCell>
                                            <TableCell>
                                                <Skeleton style={{ transform: 'scale(1, 1)' }} width={200} height={32} />
                                            </TableCell>
                                            <TableCell style={{ width: '100%' }}>
                                                <Skeleton style={{ transform: 'scale(1, 1)' }} width={'100%'} height={32} />
                                            </TableCell>
                                            <TableCell>
                                                <Skeleton style={{ transform: 'scale(1, 1)' }} width={200} height={32} />
                                            </TableCell>
                                            <TableCell>
                                                <Skeleton style={{ transform: 'scale(1, 1)' }} width={200} height={32} />
                                            </TableCell>
                                        </TableRow>
                                    ))
                                }
                            </TableBody>
                        </Table>
                    </div>
                </div>
            </Box>
        </Page >
    );
}

export default ShowData
