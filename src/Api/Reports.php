<?php

namespace Abivia\Plaid\Api;

use Abivia\Plaid\PlaidRequestException;
use Illuminate\Http\Client\Response;

class Reports extends AbstractResource
{
    /**
     * Create an Asset Report.
     *
     * @param  array<string>  $accessTokens
     * @param  array<string,mixed>  $options
     *
     * @throws PlaidRequestException
     */
    public function createAssetReport(array $accessTokens, int $daysRequested, array $options = []): self
    {
        $this->sendRequest(
            'asset_report/create',
            [
                'access_tokens' => $accessTokens,
                'days_requested' => $daysRequested,
                'options' => (object) $options,
            ]
        );

        return $this;
    }

    /**
     * Refresh an Asset Report.
     *
     * @param  array<string,mixed>  $options
     *
     * @throws PlaidRequestException
     */
    public function refreshAssetReport(
        string $assetReportToken, int $daysRequested, array $options = []
    ): self {
        $this->sendRequest(
            'asset_report/refresh',
            [
                'asset_report_token' => $assetReportToken,
                'days_requested' => $daysRequested,
                'options' => (object) $options,
            ]
        );

        return $this;
    }

    /**
     * Filter an Asset Report by specifying which Accounts to exclude.
     *
     * @param  array<string>  $excludeAccounts
     *
     * @throws PlaidRequestException
     */
    public function filterAssetReport(string $assetReportToken, array $excludeAccounts): self
    {
        $this->sendRequest(
            'asset_report/filter',
            [
                'asset_report_token' => $assetReportToken,
                'account_ids_to_exclude' => $excludeAccounts,
            ]
        );

        return $this;
    }

    /**
     * Get an Asset report.
     *
     * @throws PlaidRequestException
     */
    public function getAssetReport(string $assetReportToken, bool $includeInsights = false): self
    {
        $this->sendRequest(
            'asset_report/get',
            [
                'asset_report_token' => $assetReportToken,
                'include_insights' => $includeInsights,
            ]
        );

        return $this;
    }

    /**
     * Get an Asset report in PDF format.
     *
     * @throws PlaidRequestException
     */
    public function getAssetReportPdf(string $assetReportToken): Response
    {
        return $this->sendRequestRawResponse(
            'asset_report/pdf/get',
            ['asset_report_token' => $assetReportToken]
        );
    }

    /**
     * Remove an Asset Report.
     *
     * @throws PlaidRequestException
     */
    public function removeAssetReport(string $assetReportToken): self
    {
        $this->sendRequest(
            'asset_report/remove',
            ['asset_report_token' => $assetReportToken]
        );

        return $this;
    }

    /**
     * Create an Audit Copy of an Asset Report.
     *
     * @throws PlaidRequestException
     */
    public function createAssetReportAuditCopy(string $assetReportToken, string $auditorId): self
    {
        $this->sendRequest('asset_report/audit_copy/create', [
            'asset_report_token' => $assetReportToken,
            'auditor_id' => $auditorId,
        ]);

        return $this;
    }

    /**
     * Remove an Audit Copy.
     *
     * @throws PlaidRequestException
     */
    public function removeAssetReportAuditCopy(string $auditCopyToken): self
    {
        $this->sendRequest(
            'asset_report/audit_copy/remove',
            ['audit_copy_token' => $auditCopyToken]
        );

        return $this;
    }
}
