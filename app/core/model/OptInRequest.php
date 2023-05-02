<?php
class OptInRequest {
    private ?int $id;
    private string $site_id;
    private string $site_name;
    private int $phone;
    private int $status;
    private int $created;
    private string $hash;

    public function __construct($id, $site_id, $site_name, $phone, $status, $created, $hash) {
        $this->id = $id;
        $this->site_id = $site_id;
        $this->site_name = $site_name;
        $this->phone = $phone;
        $this->status = $status;
        $this->created = $created;
        $this->hash = $hash;
    }

    /**
     * @return int
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSiteId(): string {
        return $this->site_id;
    }

    /**
     * @return string
     */
    public function getSiteName(): string {
        return $this->site_name;
    }

    /**
     * @return int
     */
    public function getPhone(): int {
        return $this->phone;
    }

    /**
     * @return int
     */
    public function getStatus(): int {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getCreated(): int {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getHash(): string {
        return $this->hash;
    }

    public function setStatus(int $status): void {
        $this->status = $status;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'site_id' => $this->site_id,
            'site_name' => $this->site_name,
            'phone' => $this->phone,
            'status' => $this->status,
            'created' => $this->created,
            'hash' => $this->hash,
        ];
    }
}