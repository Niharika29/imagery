<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/spanner/v1/spanner.proto

namespace Google\Cloud\Spanner\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request for [PartitionQuery][google.spanner.v1.Spanner.PartitionQuery]
 *
 * Generated from protobuf message <code>google.spanner.v1.PartitionQueryRequest</code>
 */
class PartitionQueryRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The session used to create the partitions.
     *
     * Generated from protobuf field <code>string session = 1;</code>
     */
    private $session = '';
    /**
     * Read only snapshot transactions are supported, read/write and single use
     * transactions are not.
     *
     * Generated from protobuf field <code>.google.spanner.v1.TransactionSelector transaction = 2;</code>
     */
    private $transaction = null;
    /**
     * The query request to generate partitions for. The request will fail if
     * the query is not root partitionable. The query plan of a root
     * partitionable query has a single distributed union operator. A distributed
     * union operator conceptually divides one or more tables into multiple
     * splits, remotely evaluates a subquery independently on each split, and
     * then unions all results.
     *
     * Generated from protobuf field <code>string sql = 3;</code>
     */
    private $sql = '';
    /**
     * The SQL query string can contain parameter placeholders. A parameter
     * placeholder consists of `'&#64;'` followed by the parameter
     * name. Parameter names consist of any combination of letters,
     * numbers, and underscores.
     * Parameters can appear anywhere that a literal value is expected.  The same
     * parameter name can be used more than once, for example:
     *   `"WHERE id > &#64;msg_id AND id < &#64;msg_id + 100"`
     * It is an error to execute an SQL query with unbound parameters.
     * Parameter values are specified using `params`, which is a JSON
     * object whose keys are parameter names, and whose values are the
     * corresponding parameter values.
     *
     * Generated from protobuf field <code>.google.protobuf.Struct params = 4;</code>
     */
    private $params = null;
    /**
     * It is not always possible for Cloud Spanner to infer the right SQL type
     * from a JSON value.  For example, values of type `BYTES` and values
     * of type `STRING` both appear in [params][google.spanner.v1.PartitionQueryRequest.params] as JSON strings.
     * In these cases, `param_types` can be used to specify the exact
     * SQL type for some or all of the SQL query parameters. See the
     * definition of [Type][google.spanner.v1.Type] for more information
     * about SQL types.
     *
     * Generated from protobuf field <code>map<string, .google.spanner.v1.Type> param_types = 5;</code>
     */
    private $param_types;
    /**
     * Additional options that affect how many partitions are created.
     *
     * Generated from protobuf field <code>.google.spanner.v1.PartitionOptions partition_options = 6;</code>
     */
    private $partition_options = null;

    public function __construct() {
        \GPBMetadata\Google\Spanner\V1\Spanner::initOnce();
        parent::__construct();
    }

    /**
     * Required. The session used to create the partitions.
     *
     * Generated from protobuf field <code>string session = 1;</code>
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Required. The session used to create the partitions.
     *
     * Generated from protobuf field <code>string session = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setSession($var)
    {
        GPBUtil::checkString($var, True);
        $this->session = $var;

        return $this;
    }

    /**
     * Read only snapshot transactions are supported, read/write and single use
     * transactions are not.
     *
     * Generated from protobuf field <code>.google.spanner.v1.TransactionSelector transaction = 2;</code>
     * @return \Google\Cloud\Spanner\V1\TransactionSelector
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Read only snapshot transactions are supported, read/write and single use
     * transactions are not.
     *
     * Generated from protobuf field <code>.google.spanner.v1.TransactionSelector transaction = 2;</code>
     * @param \Google\Cloud\Spanner\V1\TransactionSelector $var
     * @return $this
     */
    public function setTransaction($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Spanner\V1\TransactionSelector::class);
        $this->transaction = $var;

        return $this;
    }

    /**
     * The query request to generate partitions for. The request will fail if
     * the query is not root partitionable. The query plan of a root
     * partitionable query has a single distributed union operator. A distributed
     * union operator conceptually divides one or more tables into multiple
     * splits, remotely evaluates a subquery independently on each split, and
     * then unions all results.
     *
     * Generated from protobuf field <code>string sql = 3;</code>
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * The query request to generate partitions for. The request will fail if
     * the query is not root partitionable. The query plan of a root
     * partitionable query has a single distributed union operator. A distributed
     * union operator conceptually divides one or more tables into multiple
     * splits, remotely evaluates a subquery independently on each split, and
     * then unions all results.
     *
     * Generated from protobuf field <code>string sql = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setSql($var)
    {
        GPBUtil::checkString($var, True);
        $this->sql = $var;

        return $this;
    }

    /**
     * The SQL query string can contain parameter placeholders. A parameter
     * placeholder consists of `'&#64;'` followed by the parameter
     * name. Parameter names consist of any combination of letters,
     * numbers, and underscores.
     * Parameters can appear anywhere that a literal value is expected.  The same
     * parameter name can be used more than once, for example:
     *   `"WHERE id > &#64;msg_id AND id < &#64;msg_id + 100"`
     * It is an error to execute an SQL query with unbound parameters.
     * Parameter values are specified using `params`, which is a JSON
     * object whose keys are parameter names, and whose values are the
     * corresponding parameter values.
     *
     * Generated from protobuf field <code>.google.protobuf.Struct params = 4;</code>
     * @return \Google\Protobuf\Struct
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * The SQL query string can contain parameter placeholders. A parameter
     * placeholder consists of `'&#64;'` followed by the parameter
     * name. Parameter names consist of any combination of letters,
     * numbers, and underscores.
     * Parameters can appear anywhere that a literal value is expected.  The same
     * parameter name can be used more than once, for example:
     *   `"WHERE id > &#64;msg_id AND id < &#64;msg_id + 100"`
     * It is an error to execute an SQL query with unbound parameters.
     * Parameter values are specified using `params`, which is a JSON
     * object whose keys are parameter names, and whose values are the
     * corresponding parameter values.
     *
     * Generated from protobuf field <code>.google.protobuf.Struct params = 4;</code>
     * @param \Google\Protobuf\Struct $var
     * @return $this
     */
    public function setParams($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Struct::class);
        $this->params = $var;

        return $this;
    }

    /**
     * It is not always possible for Cloud Spanner to infer the right SQL type
     * from a JSON value.  For example, values of type `BYTES` and values
     * of type `STRING` both appear in [params][google.spanner.v1.PartitionQueryRequest.params] as JSON strings.
     * In these cases, `param_types` can be used to specify the exact
     * SQL type for some or all of the SQL query parameters. See the
     * definition of [Type][google.spanner.v1.Type] for more information
     * about SQL types.
     *
     * Generated from protobuf field <code>map<string, .google.spanner.v1.Type> param_types = 5;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getParamTypes()
    {
        return $this->param_types;
    }

    /**
     * It is not always possible for Cloud Spanner to infer the right SQL type
     * from a JSON value.  For example, values of type `BYTES` and values
     * of type `STRING` both appear in [params][google.spanner.v1.PartitionQueryRequest.params] as JSON strings.
     * In these cases, `param_types` can be used to specify the exact
     * SQL type for some or all of the SQL query parameters. See the
     * definition of [Type][google.spanner.v1.Type] for more information
     * about SQL types.
     *
     * Generated from protobuf field <code>map<string, .google.spanner.v1.Type> param_types = 5;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setParamTypes($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Spanner\V1\Type::class);
        $this->param_types = $arr;

        return $this;
    }

    /**
     * Additional options that affect how many partitions are created.
     *
     * Generated from protobuf field <code>.google.spanner.v1.PartitionOptions partition_options = 6;</code>
     * @return \Google\Cloud\Spanner\V1\PartitionOptions
     */
    public function getPartitionOptions()
    {
        return $this->partition_options;
    }

    /**
     * Additional options that affect how many partitions are created.
     *
     * Generated from protobuf field <code>.google.spanner.v1.PartitionOptions partition_options = 6;</code>
     * @param \Google\Cloud\Spanner\V1\PartitionOptions $var
     * @return $this
     */
    public function setPartitionOptions($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Spanner\V1\PartitionOptions::class);
        $this->partition_options = $var;

        return $this;
    }

}

