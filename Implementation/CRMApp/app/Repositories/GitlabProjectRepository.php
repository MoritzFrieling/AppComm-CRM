<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\GitlabProjectRepositoryInterface;
use App\Models\GitlabProject;
use GrahamCampbell\GitLab\Facades\GitLab;
use GrahamCampbell\GitLab\GitLabManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class GitlabProjectRepository implements GitlabProjectRepositoryInterface
{
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository,
        protected GitLabManager $gitlab
    ) {
    }

    public function allProjects(): array
    {
        return array_map(function ($project) {
            return [
                'id' => $project['id'],
                'name' => $project['name'],
            ];
        }, $this->gitlab->projects()->all([
            'membership' => true,
            'simple' => true
        ]));
    }

    public function all(string $registration_number): array|Collection
    {
        return GitlabProject::query()
            ->whereHas('customer', function ($query) use ($registration_number) {
                $query->where('registration_number', $registration_number);
            })
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function assign(string $registration_number, int|string $id): Builder|Model
    {
        $projectData = $this->gitlab->projects()->show($id);
        $customer = $this->customerRepository->find($registration_number);

        return GitlabProject::query()->createOrFirst([
            'customer_id' => $customer->id,
            'gitlab_project_id' => $projectData['id'],
            'name' => $projectData['name'],
        ]);
    }

    public function find(string $registration_number, $id): Model|Builder
    {
        return GitlabProject::query()
            ->whereHas('customer', function ($query) use ($registration_number) {
                $query->where('registration_number', $registration_number);
            })
            ->where('id', $id)
            ->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function unassign(string $registration_number, $id)
    {
        return GitlabProject::query()->whereHas('customer', function ($query) use ($registration_number) {
            $query->where('registration_number', $registration_number);
        })->where('gitlab_project_id', $id)->delete();
    }
}
